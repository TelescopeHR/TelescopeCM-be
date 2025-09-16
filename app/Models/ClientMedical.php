<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMedical extends Model
{
    use HasFactory;

    protected $table = 'client_medicals';

    protected $fillable = [
        'user_id',
        'manual_medical_id',
        'admitted_at',
        'living_with',
        'able_to_respond',
        'allergies',
        'classification',
        'condition',
        'priority',
        'dnr',
        'medical_instructions',
    ];

    protected $casts = [
        'admitted_at' => 'date',
    ];
    public const CLASSIFICATIONS = [
        1 => 'class I',
        2 => 'class II',
        3 => 'class III',
        4 => 'class IV',
    ];

    public const CONDITIONS = [
        1 => 'fair',
        2 => 'good',
        3 => 'poor',
    ];

    public const BINARY_OPTIONS = [
        0 => 'no',
        1 => 'yes',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
