<?php

namespace App\Models;

use Carbon\Carbon;
use App\Casts\TimeCast;
use App\Traits\CreatedByTrait;

class ScheduleType extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'type_id');
    }
}
