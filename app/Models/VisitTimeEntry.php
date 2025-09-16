<?php

namespace App\Models;

use Carbon\Carbon;

class VisitTimeEntry extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_id',
        'care_worker_id',
        'started_at',
        'stopped_at',
        'duration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * Get the visit that owns the time entry.
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Get the care worker who recorded the time entry.
     */
    public function careWorker()
    {
        return $this->belongsTo(User::class, 'care_worker_id');
    }
}
