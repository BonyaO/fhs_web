<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'year',
        'description',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Get the issues for the volume.
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class)->orderBy('number');
    }

    /**
     * Get published issues for the volume.
     */
    public function publishedIssues(): HasMany
    {
        return $this->hasMany(Issue::class)
            ->where('is_published', true)
            ->orderBy('number');
    }

    /**
     * Get all articles through issues.
     */
    public function articles()
    {
        return $this->hasManyThrough(Article::class, Issue::class);
    }

    /**
     * Scope a query to only include published volumes.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Scope a query to order by year descending.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('year', 'desc');
    }

    /**
     * Get the volume's display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return "Volume {$this->number} ({$this->year})";
    }

    /**
     * Check if the volume is published.
     */
    public function isPublished(): bool
    {
        return !is_null($this->published_at);
    }

    /**
     * Get the total number of articles in this volume.
     */
    public function getArticleCountAttribute(): int
    {
        return $this->articles()->count();
    }
}