<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\CreatedByTrait;

class ShiftNote extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var string
     */
    public static $title = 'date';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'visit_id',
        'created_by',
        'message',
        'date_at',
        'from_date_at',
        'to_date_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'date_at' => 'date',
        'from_date_at' => 'from_date',
        'to_date_at' => 'to_date',
    ];

    public const NOTE_LIST_LIMIT = 5;

    /**
     * @var array
     */
    protected $search = [
        'message',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'message',
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return string|null
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function getDateAttribute()
    {
        return !empty($this->date_at)
            ? Carbon::parse($this->date_at)->toFormattedDateString()
            : null;
    }
}
