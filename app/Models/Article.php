<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'issue_id',
        'title',
        'slug',
        'abstract',
        'keywords',
        'page_start',
        'page_end',
        'doi',
        'submission_date',
        'acceptance_date',
        'publication_date',
        'article_type',
        'language',
        'license',
        'status',
        'is_published',
        'view_count',
        'download_count',
        'featured',
        'order',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submission_date' => 'date',
        'acceptance_date' => 'date',
        'publication_date' => 'date',
        'is_published' => 'boolean',
        'featured' => 'boolean',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['page_range', 'formatted_authors'];

    /**
     * Get the issue that owns the article.
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the volume through the issue.
     */
    public function volume()
    {
        return $this->issue->volume();
    }

    /**
     * Get the authors for the article.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'article_author')
            ->withPivot('author_order', 'is_corresponding', 'affiliation_at_time', 'contribution')
            ->orderBy('article_author.author_order');
    }

    /**
     * Get the corresponding author.
     */
    public function correspondingAuthor()
    {
        return $this->authors()->wherePivot('is_corresponding', true)->first();
    }

    /**
     * Get the files for the article.
     */
    public function files(): HasMany
    {
        return $this->hasMany(ArticleFile::class);
    }

    /**
     * Get the primary PDF file.
     */
    public function primaryFile(): HasOne
    {
        return $this->hasOne(ArticleFile::class)
            ->where('file_type', 'pdf')
            ->where('is_primary', true);
    }

    /**
     * Get supplementary files.
     */
    public function supplementaryFiles(): HasMany
    {
        return $this->hasMany(ArticleFile::class)
            ->where('file_type', 'supplementary');
    }

    /**
     * Get the views for the article.
     */
    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    /**
     * Get the citations for the article.
     */
    public function citations(): HasMany
    {
        return $this->hasMany(ArticleCitation::class)->orderBy('citation_order');
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include featured articles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include articles of a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('article_type', $type);
    }

    /**
     * Scope a query to search articles.
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('abstract', 'LIKE', "%{$term}%")
              ->orWhere('keywords', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopeMostViewed($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * Scope a query to order by most downloaded.
     */
    public function scopeMostDownloaded($query)
    {
        return $query->orderBy('download_count', 'desc');
    }

    /**
     * Get the article's page range.
     */
    public function getPageRangeAttribute(): ?string
    {
        if ($this->page_start && $this->page_end) {
            return "{$this->page_start}-{$this->page_end}";
        }
        
        return null;
    }

    /**
     * Get formatted list of authors.
     */
    public function getFormattedAuthorsAttribute(): string
    {
        if ($this->authors->isEmpty()) {
            return '';
        }

        $names = $this->authors->map(function ($author) {
            return $author->full_name;
        });

        if ($names->count() === 1) {
            return $names->first();
        }

        if ($names->count() === 2) {
            return $names->join(' and ');
        }

        $last = $names->pop();
        return $names->join(', ') . ', and ' . $last;
    }

    /**
     * Get the article's URL.
     */
    public function getUrlAttribute(): string
    {
        return route('journal.article', $this->slug);
    }

    /**
     * Get the article's full citation.
     */
    public function getCitationAttribute(): string
    {
        $authors = $this->authors->map(fn($author) => $author->citation_name)->take(3);
        $authorString = $authors->count() > 3 
            ? $authors->join(', ') . ', et al.' 
            : $authors->join(', ', ' & ');
        $year = $this->publication_date?->year ?? $this->issue->volume->year;
        $title = $this->title;
        $journal = config('journal.name', 'African Annals of Health Sciences');
        $volume = $this->issue->volume->number;
        $issue = $this->issue->number;
        $pages = $this->page_range;

        $citation = "{$authorString} ({$year}). {$title}. {$journal}, {$volume}({$issue})";
        
        if ($pages) {
            $citation .= ", {$pages}";
        }

        if ($this->doi) {
            $citation .= ". https://doi.org/{$this->doi}";
        }

        return $citation;
    }

    /**
     * Get keywords as an array.
     */
    public function getKeywordsArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            return [];
        }

        // Handle both comma-separated and JSON formatted keywords
        if (Str::startsWith($this->keywords, '[')) {
            return json_decode($this->keywords, true) ?? [];
        }

        return array_map('trim', explode(',', $this->keywords));
    }

    /**
     * Check if the article is published.
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    /**
     * Increment download count.
     */
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    /**
     * Generate a unique slug from the title.
     */
    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = 1;
        $originalSlug = $slug;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug if not provided
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
        });

        // Automatically set published_at when is_published is set to true
        static::saving(function ($article) {
            if ($article->is_published && is_null($article->published_at)) {
                $article->published_at = now();
            }
        });
    }
}