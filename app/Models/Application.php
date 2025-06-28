<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'level',
        'user_id',
        'exam_center_id',
        'region_id', 'division_id', 'sub_division_id',
        'name',
        'surname',
        'dob',
        'pob',
        'primary_language',
        'email',
        'telephone',
        'idc_number',
        'gender',
        'bankref',
        'marital_status',
        'is_civil_servant',
        'address',
        'option',
        'country',
        'mother_name',
        'mother_address',
        'mother_contact',
        'father_name',
        'father_address',
        'father_contact',
        'guardian_name',
        'guardian_address',
        'guardian_contact',
        'passport',
        'birthcert',
        'bankrecipt',
        'has_math',
        'has_english',
        'validated_on',
        'admitted_on',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examCenter()
    {
        return $this->belongsTo(ExamCenter::class);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }
}
