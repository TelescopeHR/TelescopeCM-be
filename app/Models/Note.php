<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public const CLIENT_NOTE_TYPES = [
        1 => 'ATTENDANT COMPLAINT',
        2 => 'REFUSAL OF SERVICES',
        3 => 'AGENCY COMPLAINT',
        4 => 'NON-COMPLIANT',
        5 => 'CLIENT COMPLIANT'
    ];

    public const EMPLOYEE_NOTE_TYPES = [
        6 => 'TERMINATION',
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
