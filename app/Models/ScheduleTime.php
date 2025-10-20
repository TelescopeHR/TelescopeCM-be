<?php

namespace App\Models;

use Carbon\Carbon;
use App\Casts\TimeCast;
use App\Traits\CreatedByTrait;

class ScheduleTime extends BaseModel
{
    use CreatedByTrait;

    const DAYS_OF_WEEK = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'day_of_week',
        'time_from',
        'time_to',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'schedule_id' => 'integer',
        'day_of_week' => 'integer',
        'time_from' => TimeCast::class,
        'time_to' => TimeCast::class,
    ];

    /**
     * @var array
     */
    protected $search = [
        'id',
    ];

    /**
     * @var array
     */
    protected $order = [
        'schedule_id' => 'desc',
        'day_of_week' => 'desc',
        'id' => 'asc',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
