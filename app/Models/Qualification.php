<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'qualification_type_id',
        'school',
        'points',
        'year',
        'certificate',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function qualificationType()
    {
        return $this->belongsTo(QualificationType::class);
    }
}
