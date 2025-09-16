<?php

namespace App\Models;

use Carbon\Carbon;
use App\Casts\TimeCast;
use App\Traits\CreatedByTrait;

class Visit extends BaseModel
{
    use CreatedByTrait;

    const STATUS_CANCELED = -1;
    const STATUS_FUTURE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETED = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'care_worker_id',
        'schedule_id',
        'type',
        'pay_rate',
        'date_at',
        'time_in',
        'time_out',
        'verified_in',
        'verified_out',
    ];


    /**
     * @var array
     */
    protected $search = [
        'name',
        'outcomes',
        'zip',
        'city',
        'address',
    ];

    /**
     * @var array
     */
    protected $order = [
        'date_at' => 'desc',
        'id' => 'asc',
    ];

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_FUTURE => __('Future'),
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_COMPLETED => __('Complete'),
            self::STATUS_CANCELED => __('Canceled'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_FUTURE => 'info',
            self::STATUS_ACTIVE => 'success',
            self::STATUS_COMPLETED => 'warning',
            self::STATUS_CANCELED => 'danger',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function careWorker()
    {
        return $this->belongsTo(User::class, 'care_worker_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany(User::class, 'visit_workers', 'visit_id', 'care_worker_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeEntries()
    {
        return $this->hasMany(VisitTimeEntry::class);
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @return mixed
     */
    public function getStatusTextAttribute()
    {
        return static::statuses()[$this->status] ?? null;
    }

    /**
     * @return mixed
     */
    public function getStatusBadgeClassAttribute()
    {
        return static::statusBadgeClasses()[$this->status] ?? null;
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

    /**
     * @return mixed
     */
    public function getFullAddressAttribute()
    {
        $fields = [
            $this->zip,
            $this->city,
            $this->address,
        ];

        return implode(", ", array_filter($fields));
    }

    /**
     * Get client full address
     * @return string
     */
    public function getClientFullAddressAttribute(): string
    {
        $client = $this->client;

        $fields = [
            $client?->zip,
            $client?->city,
            $client?->address,
        ];

        return implode(', ', array_filter($fields));
    }

    /**
     * @return mixed
     */
    public function getWorkerIdsAttribute()
    {
        return implode(',', $this->workers->pluck('id')->toArray());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function helpTypes()
    {
        return $this->belongsToMany(HelpType::class, 'visit_help_types')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function moodTypes()
    {
        return $this->belongsToMany(MoodType::class, 'visit_mood_types')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitTypes()
    {
        return $this->belongsToMany(VisitType::class, 'visit_visit_types')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shiftNotes()
    {
        return $this->hasMany(ShiftNote::class);
    }

    public function tasks()
    {
        return $this->hasMany(VisitTask::class);
    }

    /**
     * @return string|null
     */
    public function getFormattedDateTimeAttribute(): ?string
    {
        if (!$this->date_at || !$this->time_in || !$this->time_out) {
            return null;
        }

        try {
            $date = Carbon::parse($this->date_at)->format('d/m/Y');

            $timeIn = Carbon::createFromFormat('H:i:s', $this->time_in)->format('g:i A');
            $timeOut = Carbon::createFromFormat('H:i:s', $this->time_out)->format('g:i A');

            return "$date $timeIn - $timeOut";
        } catch (\Exception $e) {
            return null;
        }
    }
}
