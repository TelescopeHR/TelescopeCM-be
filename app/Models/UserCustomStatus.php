<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TimestampTrait;

class UserCustomStatus extends Model
{
    use TimestampTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_custom_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'custom_status_id',
        'notes',
    ];

    /**
     * Get the user that owns the custom status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the custom status that belongs to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customStatus()
    {
        return $this->belongsTo(CustomStatus::class);
    }
}
