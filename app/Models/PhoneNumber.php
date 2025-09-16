<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    public const MOBILE_TYPES = [
        1 => 'home',
        2 => 'mobile',
        3 => 'other',
    ];

    protected $fillable = [
        'user_id',
        'phone',
        'phone_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
