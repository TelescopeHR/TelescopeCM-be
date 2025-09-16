<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TimestampTrait;

class CustomStatus extends Model
{
    use TimestampTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that have this custom status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_custom_statuses')
            ->withPivot('notes')
            ->withTimestamps();
    }
}
