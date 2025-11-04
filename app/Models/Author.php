<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'orcid',
        'affiliation',
        'department',
        'bio',
        'country',
        'website',
        'google_scholar',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'initials'];

    /**
     * Get the articles for the author.
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)
            ->withPivot('author_order', 'is_corresponding', 'affiliation_at_time', 'contribution')
            ->orderBy('published_at', 'desc');
    }

    /**
     * Get published articles for the author.
     */
    public function publishedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)
            ->where('is_published', true)
            ->withPivot('author_order', 'is_corresponding', 'affiliation_at_time', 'contribution')
            ->withTimestamps()
            ->orderBy('published_at', 'desc');
    }

    /**
     * Get the author's full name.
     */
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->surname,
        ]);

        return implode(' ', $parts);
    }

    /**
     * Get the author's name in citation format (Last, First M.).
     */
    public function getCitationNameAttribute(): string
    {
        $name = "{$this->surname}, {$this->first_name}";

        return $name;
    }

    /**
     * Get the author's initials.
     */
    public function getInitialsAttribute(): string
    {
        $initials = substr($this->first_name, 0, 1);
        $initials .= substr($this->surname, 0, 1);

        return strtoupper($initials);
    }

    /**
     * Get the author's short name (First Initial. Last).
     */
    public function getShortNameAttribute(): string
    {
        $firstInitial = substr($this->first_name, 0, 1);
        return "{$firstInitial}. {$this->last_name}";
    }

    /**
     * Get ORCID URL.
     */
    public function getOrcidUrlAttribute(): ?string
    {
        if ($this->orcid) {
            // Remove any existing URL prefix
            $orcid = str_replace(['https://orcid.org/', 'http://orcid.org/'], '', $this->orcid);
            return "https://orcid.org/{$orcid}";
        }

        return null;
    }

    /**
     * Scope a query to search authors by name.
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'LIKE', "%{$term}%")
              ->orWhere('surname', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope a query to filter by country.
     */
    public function scopeFromCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    /**
     * Scope a query to order by last name.
     */
    public function scopeOrderByName($query)
    {
        return $query->orderBy('surname')->orderBy('first_name');
    }

    /**
     * Get the total number of published articles.
     */
    public function getArticleCountAttribute(): int
    {
        return $this->publishedArticles()->count();
    }

    /**
     * Check if author has ORCID.
     */
    public function hasOrcid(): bool
    {
        return !is_null($this->orcid);
    }

    /**
     * Get the author's profile URL (if we create author profile pages).
     */
    public function getProfileUrlAttribute(): string
    {
        return route('journal.author', $this->id);
    }
}