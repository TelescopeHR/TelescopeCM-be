<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class VisitReason extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'description',
    ];
}
