<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationType extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'name'];

    public static $qualifications = [
        1 => 'Secondary school',
        2 => 'High School',
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }
}
