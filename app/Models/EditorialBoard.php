<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditorialBoard extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'editorial_board';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'affiliation',
        'department',
        'country',
        'email',
        'bio',
        'photo',
        'orcid',
        'google_scholar',
        'research_interests',
        'order',
        'is_active',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Scope a query to only include active board members.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive board members.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to filter by role.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Get the photo URL.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return Storage::disk('journal')->url('board/' . $this->photo);
        }

        return null;
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
     * Get the role label (formatted nicely).
     */
    public function getRoleLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->role));
    }

    /**
     * Get research interests as an array.
     */
    public function getResearchInterestsArrayAttribute(): array
    {
        if (empty($this->research_interests)) {
            return [];
        }

        // Handle both comma-separated and newline-separated interests
        if (strpos($this->research_interests, "\n") !== false) {
            return array_map('trim', explode("\n", $this->research_interests));
        }

        return array_map('trim', explode(',', $this->research_interests));
    }

    /**
     * Check if the member is currently serving.
     */
    public function isCurrentlyServing(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        // Check start date
        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        // Check end date
        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Get the years of service.
     */
    public function getYearsOfServiceAttribute(): ?string
    {
        if (!$this->start_date) {
            return null;
        }

        $start = $this->start_date->format('Y');
        
        if ($this->end_date) {
            $end = $this->end_date->format('Y');
            return $start === $end ? $start : "{$start} - {$end}";
        }

        return "{$start} - Present";
    }

    /**
     * Get board members grouped by role.
     */
    public static function getGroupedByRole(): array
    {
        $members = static::active()->ordered()->get();

        // Define role hierarchy
        $roleOrder = [
            'editor_in_chief',
            'deputy_editor',
            'managing_editor',
            'associate_editor',
            'section_editor',
            'board_member',
            'advisory_board',
        ];

        $grouped = [];

        foreach ($roleOrder as $role) {
            $roleMembers = $members->where('role', $role);
            if ($roleMembers->isNotEmpty()) {
                $grouped[$role] = $roleMembers;
            }
        }

        // Add any other roles not in the predefined list
        $otherRoles = $members->whereNotIn('role', $roleOrder)->groupBy('role');
        foreach ($otherRoles as $role => $roleMembers) {
            $grouped[$role] = $roleMembers;
        }

        return $grouped;
    }

    /**
     * Get the role priority for sorting.
     */
    public static function getRolePriority(string $role): int
    {
        $priorities = [
            'editor_in_chief' => 1,
            'deputy_editor' => 2,
            'managing_editor' => 3,
            'associate_editor' => 4,
            'section_editor' => 5,
            'board_member' => 6,
            'advisory_board' => 7,
        ];

        return $priorities[$role] ?? 999;
    }

    /**
     * Delete the photo from storage when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($member) {
            // Delete the physical photo from storage
            if ($member->photo && Storage::disk('journal')->exists('board/' . $member->photo)) {
                Storage::disk('journal')->delete('board/' . $member->photo);
            }
        });
    }
}