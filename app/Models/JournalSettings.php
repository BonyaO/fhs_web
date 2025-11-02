<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class JournalSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'journal_name',
        'journal_acronym',
        'tagline',
        'description',
        'issn_print',
        'issn_online',
        'publisher',
        'publication_frequency',
        'contact_email',
        'submission_email',
        'copyright_policy',
        'open_access_statement',
        'ethical_guidelines',
        'peer_review_policy',
        'submission_guidelines',
        'manuscript_preparation',
        'indexing_info',
        'logo',
        'cover_default',
        'twitter',
        'facebook',
        'linkedin',
    ];

    /**
     * Get the singleton instance of journal settings.
     */
    public static function getInstance(): self
    {
        return Cache::remember('journal_settings', 3600, function () {
            $settings = static::first();

            // Create default settings if none exist
            if (!$settings) {
                $settings = static::create([
                    'journal_name' => 'African Annals of Health Sciences',
                    'description' => 'A peer-reviewed open access journal publishing original research in health sciences.',
                    'publication_frequency' => 'Biannual',
                    'contact_email' => 'editor@africanannals.org',
                ]);
            }

            return $settings;
        });
    }

    /**
     * Clear the settings cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('journal_settings');
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return Storage::disk('journal')->url('assets/' . $this->logo);
        }

        return null;
    }

    /**
     * Get the default cover URL.
     */
    public function getCoverDefaultUrlAttribute(): ?string
    {
        if ($this->cover_default) {
            return Storage::disk('journal')->url('assets/' . $this->cover_default);
        }

        return null;
    }

    /**
     * Get the full journal title (name with acronym if available).
     */
    public function getFullTitleAttribute(): string
    {
        if ($this->journal_acronym) {
            return "{$this->journal_name} ({$this->journal_acronym})";
        }

        return $this->journal_name;
    }

    /**
     * Get Twitter URL.
     */
    public function getTwitterUrlAttribute(): ?string
    {
        if ($this->twitter) {
            $handle = ltrim($this->twitter, '@');
            return "https://twitter.com/{$handle}";
        }

        return null;
    }

    /**
     * Get formatted ISSN (print).
     */
    public function getFormattedIssnPrintAttribute(): ?string
    {
        return $this->formatIssn($this->issn_print);
    }

    /**
     * Get formatted ISSN (online).
     */
    public function getFormattedIssnOnlineAttribute(): ?string
    {
        return $this->formatIssn($this->issn_online);
    }

    /**
     * Format ISSN with hyphen (e.g., 1234-5678).
     */
    protected function formatIssn(?string $issn): ?string
    {
        if (!$issn) {
            return null;
        }

        // Remove any existing formatting
        $issn = preg_replace('/[^0-9X]/', '', $issn);

        // Format as XXXX-XXXX
        if (strlen($issn) === 8) {
            return substr($issn, 0, 4) . '-' . substr($issn, 4);
        }

        return $issn;
    }

    /**
     * Check if the journal has ISSN.
     */
    public function hasIssn(): bool
    {
        return !is_null($this->issn_print) || !is_null($this->issn_online);
    }

    /**
     * Check if all social media links are configured.
     */
    public function hasSocialMedia(): bool
    {
        return !is_null($this->twitter) || !is_null($this->facebook) || !is_null($this->linkedin);
    }

    /**
     * Get indexing information as an array.
     */
    public function getIndexingInfoArrayAttribute(): array
    {
        if (empty($this->indexing_info)) {
            return [];
        }

        // Handle both comma-separated and newline-separated
        if (strpos($this->indexing_info, "\n") !== false) {
            return array_filter(array_map('trim', explode("\n", $this->indexing_info)));
        }

        return array_filter(array_map('trim', explode(',', $this->indexing_info)));
    }

    /**
     * Get the contact information array.
     */
    public function getContactInfoAttribute(): array
    {
        return [
            'email' => $this->contact_email,
            'submission_email' => $this->submission_email,
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'linkedin' => $this->linkedin,
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when settings are updated
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });

        // Prevent creating more than one settings record
        static::creating(function () {
            if (static::count() > 0) {
                throw new \Exception('Only one journal settings record is allowed. Please update the existing record.');
            }
        });

        // Prevent deletion if it's the only record
        static::deleting(function ($settings) {
            if (static::count() === 1) {
                throw new \Exception('Cannot delete the only journal settings record.');
            }
        });
    }

    /**
     * Helper to get a specific setting value.
     */
    public static function get(string $key, $default = null)
    {
        $settings = static::getInstance();
        return $settings->$key ?? $default;
    }

    /**
     * Helper to set a specific setting value.
     */
    public static function set(string $key, $value): void
    {
        $settings = static::getInstance();
        $settings->$key = $value;
        $settings->save();
    }
}
