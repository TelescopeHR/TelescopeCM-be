<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, HasUuid;

    public const CLIENT_NOTE_TYPES = [
        'ATTENDANT COMPLAINT' => 1,
        'REFUSAL OF SERVICES' => 2,
        'AGENCY COMPLAINT' => 3,
        'NON-COMPLIANT' => 4,
        'CLIENT COMPLIANT' => 5
    ];

    public const EMPLOYEE_NOTE_TYPES = [
        'TERMINATION' => 6,
    ];

    protected $fillable = [
       'title',
        'description',
        'type',
        'created_by',
        'user_id',
    ];

    public const NOTE_LIST_LIMIT = 5;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
