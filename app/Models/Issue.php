<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Issue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'volume_id',
        'number',
        'title',
        'description',
        'cover_image',
        'publication_date',
        'is_published',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the volume that owns the issue.
     */
    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }

    /**
     * Get the articles for the issue.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)->orderBy('order');
    }

    /**
     * Get published articles for the issue.
     */
    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Article::class)
            ->where('is_published', true)
            ->orderBy('order');
    }

    /**
     * Scope a query to only include published issues.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order by publication date descending.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('publication_date', 'desc');
    }

    /**
     * Get the issue's display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return "Volume {$this->volume->number}, Issue {$this->number}";
    }

    /**
     * Get the issue's full title with volume info.
     */
    public function getFullTitleAttribute(): string
    {
        $base = "Volume {$this->volume->number}, Issue {$this->number}";
        
        if ($this->title) {
            $base .= ": {$this->title}";
        }
        
        return $base;
    }

    /**
     * Get the issue's URL slug.
     */
    public function getSlugAttribute(): string
    {
        return "volume-{$this->volume->number}-issue-{$this->number}";
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if ($this->cover_image) {
            return asset('storage/journal/covers/' . $this->cover_image);
        }
        
        return null;
    }

    /**
     * Check if the issue is published.
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Get the total number of articles in this issue.
     */
    public function getArticleCountAttribute(): int
    {
        return $this->articles()->count();
    }

    /**
     * Get the published article count.
     */
    public function getPublishedArticleCountAttribute(): int
    {
        return $this->publishedArticles()->count();
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set published_at when is_published is set to true
        static::saving(function ($issue) {
            if ($issue->is_published && is_null($issue->published_at)) {
                $issue->published_at = now();
            }
        });
    }
}