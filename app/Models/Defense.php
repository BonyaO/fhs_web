<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Defense extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'venue',
        'jury_number',
        'student_name',
        'registration_number',
        'thesis_title',
        'student_photo',
        'president_name',
        'president_title',
        'rapporteur_name',
        'rapporteur_title',
        'jury_members',
        'status',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'jury_members' => 'array'
    ];

    // Accessor for formatted date and time
    protected function formattedDateTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->date->format('d/m/Y') . ' à ' . $this->time->format('H:i')
        );
    }

    // Accessor for president info
    protected function presidentInfo(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->president_title ? 
                $this->president_title . ' ' . $this->president_name : 
                $this->president_name
        );
    }

    // Accessor for rapporteur info
    protected function rapporteurInfo(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->rapporteur_title ? 
                $this->rapporteur_title . ' ' . $this->rapporteur_name : 
                $this->rapporteur_name
        );
    }

    // Get all jury members including president and rapporteur
    public function getAllJuryMembers()
    {
        $allMembers = [
            [
                'role' => 'President',
                'name' => $this->president_name,
                'title' => $this->president_title
            ],
            [
                'role' => 'Rapporteur',
                'name' => $this->rapporteur_name,
                'title' => $this->rapporteur_title
            ]
        ];

        // Add other jury members
        if ($this->jury_members) {
            foreach ($this->jury_members as $member) {
                $allMembers[] = [
                    'role' => 'Member',
                    'name' => $member['name'] ?? '',
                    'title' => $member['title'] ?? ''
                ];
            }
        }

        return $allMembers;
    }

    // Scope for filtering by status
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope for filtering by date range
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}