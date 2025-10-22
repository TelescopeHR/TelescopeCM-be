<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\CreatedByTrait;
use App\Traits\HasUuid;

class Schedule extends BaseModel
{
    use CreatedByTrait, HasUuid;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @var string
     */
    public static $title = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'care_worker_id',
        'care_plan_id',
        'type_id',
        'date_from',
        'date_to',
        'rate',
        'status',
        'schedule_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'patient_id' => 'integer',
        'care_worker_id' => 'integer',
        'care_plan_id' => 'integer',
        'type_id' => 'integer',
        'date_from' => 'date',
        'date_to' => 'date',
        'rate' => 'float',
        'status' => 'integer',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @var array
     */
    protected $search = [
        'rate',
    ];

    /**
     * @var array
     */
    protected $order = [
        'created_at' => 'desc',
        'id' => 'asc',
    ];

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_INACTIVE => __('Inactive'),
            self::STATUS_ACTIVE => __('Active'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_INACTIVE => 'danger',
            self::STATUS_ACTIVE => 'success',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
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
    public function type()
    {
        return $this->belongsTo(ScheduleType::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function times()
    {
        return $this->hasMany(ScheduleTime::class)->orderBy('day_of_week', 'asc');;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carePlan()
    {
        return $this->belongsTo(UserCarePlan::class, 'care_plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class)->defaultOrder();
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
    public function getDateStartAttribute()
    {
        return !empty($this->date_from)
            ? Carbon::parse($this->date_from)->toFormattedDateString()
            : null;
    }

    /**
     * @return string|null
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function getDateEndAttribute()
    {
        return !empty($this->date_to)
            ? Carbon::parse($this->date_to)->toFormattedDateString()
            : null;
    }

    /**
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        $fields = [
            $this->dateStart,
            $this->dateEnd,
        ];

        return optional($this->type)->name . ': ' .  implode(" - ", array_filter($fields));
    }

    /**
     * @return array
     */
    public static function list()
    {
        $list = [];
        $models = static::get();

        foreach ($models as $model) {
            $list[$model->id] = $model->fullName;
        }

        return $list;
    }
}
