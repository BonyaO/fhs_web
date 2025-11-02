<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleCitation extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'citation_text',
        'citation_order',
        'doi',
        'pubmed_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the article that owns the citation.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Scope a query to order by citation order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('citation_order');
    }

    /**
     * Get the DOI URL.
     */
    public function getDoiUrlAttribute(): ?string
    {
        if ($this->doi) {
            // Remove any existing URL prefix
            $doi = str_replace(['https://doi.org/', 'http://dx.doi.org/'], '', $this->doi);
            return "https://doi.org/{$doi}";
        }

        return null;
    }

    /**
     * Get the PubMed URL.
     */
    public function getPubmedUrlAttribute(): ?string
    {
        if ($this->pubmed_id) {
            $id = str_replace('PMID:', '', $this->pubmed_id);
            return "https://pubmed.ncbi.nlm.nih.gov/{$id}/";
        }

        return null;
    }

    /**
     * Format the citation text with linked identifiers.
     */
    public function getFormattedCitationAttribute(): string
    {
        $text = $this->citation_text;

        // Add DOI link if available
        if ($this->doi) {
            $text .= " DOI: <a href=\"{$this->doi_url}\" target=\"_blank\" rel=\"noopener\">{$this->doi}</a>";
        }

        // Add PubMed link if available
        if ($this->pubmed_id) {
            $text .= " PMID: <a href=\"{$this->pubmed_url}\" target=\"_blank\" rel=\"noopener\">{$this->pubmed_id}</a>";
        }

        return $text;
    }

    /**
     * Extract authors from citation text (basic extraction).
     */
    public function getAuthorsAttribute(): ?string
    {
        // Try to extract authors (text before year in parentheses)
        if (preg_match('/^(.+?)\s*\(\d{4}\)/', $this->citation_text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * Extract year from citation text.
     */
    public function getYearAttribute(): ?int
    {
        // Try to extract year (four digits in parentheses)
        if (preg_match('/\((\d{4})\)/', $this->citation_text, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * Check if the citation has a DOI.
     */
    public function hasDoi(): bool
    {
        return !is_null($this->doi);
    }

    /**
     * Check if the citation has a PubMed ID.
     */
    public function hasPubmedId(): bool
    {
        return !is_null($this->pubmed_id);
    }

    /**
     * Bulk create citations for an article.
     */
    public static function bulkCreateForArticle(int $articleId, array $citations): void
    {
        $data = [];
        
        foreach ($citations as $index => $citation) {
            $data[] = [
                'article_id' => $articleId,
                'citation_text' => $citation['text'] ?? $citation,
                'citation_order' => $index + 1,
                'doi' => $citation['doi'] ?? null,
                'pubmed_id' => $citation['pubmed_id'] ?? null,
                'created_at' => now(),
            ];
        }

        static::insert($data);
    }

    /**
     * Reorder citations for an article.
     */
    public static function reorderForArticle(int $articleId, array $citationIds): void
    {
        foreach ($citationIds as $order => $citationId) {
            static::where('id', $citationId)
                ->where('article_id', $articleId)
                ->update(['citation_order' => $order + 1]);
        }
    }
}