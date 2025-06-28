<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'status',
        'amount',
        'currency',
        'operator',
        'code',
        'operator_reference',
        'endpoint',
        'signature',
        'external_user',
        'app_amount',
        'phone_number',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
