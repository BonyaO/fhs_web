<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCenter extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
