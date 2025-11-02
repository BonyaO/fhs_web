<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArticleFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'file_type',
        'file_path',
        'original_filename',
        'file_size',
        'mime_type',
        'version',
        'description',
        'is_primary',
        'download_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'file_size' => 'integer',
        'version' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Get the article that owns the file.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the file's full URL.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('journal')->url($this->file_path);
    }

    /**
     * Get the file's download URL.
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('journal.article.download', [
            'article' => $this->article->slug,
            'file' => $this->id
        ]);
    }

    /**
     * Get the file size in a human-readable format.
     */
    public function getHumanFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get the file extension.
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->original_filename, PATHINFO_EXTENSION);
    }

    /**
     * Get the file type label.
     */
    public function getTypeLabel(): string
    {
        return match($this->file_type) {
            'pdf' => 'PDF Document',
            'supplementary' => 'Supplementary Material',
            'dataset' => 'Dataset',
            'image' => 'Image',
            default => ucfirst($this->file_type),
        };
    }

    /**
     * Check if the file is a PDF.
     */
    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }

    /**
     * Check if the file exists in storage.
     */
    public function exists(): bool
    {
        return Storage::disk('journal')->exists($this->file_path);
    }

    /**
     * Increment download count.
     */
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
        
        // Also increment article download count if this is a PDF
        if ($this->isPdf()) {
            $this->article->incrementDownloads();
        }
    }

    /**
     * Scope a query to only include primary files.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to only include files of a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Scope a query to order by version descending (latest first).
     */
    public function scopeLatestVersion($query)
    {
        return $query->orderBy('version', 'desc');
    }

    /**
     * Delete the file from storage when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            // Delete the physical file from storage
            if (Storage::disk('journal')->exists($file->file_path)) {
                Storage::disk('journal')->delete($file->file_path);
            }
        });

        // Ensure only one primary file per article
        static::saving(function ($file) {
            if ($file->is_primary && $file->file_type === 'pdf') {
                // Remove primary flag from other PDF files of the same article
                static::where('article_id', $file->article_id)
                    ->where('file_type', 'pdf')
                    ->where('id', '!=', $file->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}