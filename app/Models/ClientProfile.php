<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'manual_client_id',
        'client_status',
        'social_security'
    ];

    public const STATUSES = [
        1 => "Active",
        2 => "Expired",
        3 => "Hospitalized",
        4 => "On Hold",
        5 => "Pending",
        6 => "Suspended",
        7 => "Terminated",
        8 => "Transfer",
        9 => "Waiting For Active Coverage",
    ];

    public const CLIENT_LIST_LIMIT = 20;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
