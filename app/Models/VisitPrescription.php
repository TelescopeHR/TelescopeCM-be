<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\CreatedByTrait;

class VisitPrescription extends BaseModel
{
    use CreatedByTrait;

    const TYPE_MEDICATION = 0;
    const TYPE_FOOD = 1;
    const TYPE_DRINK = 2;

    const TIME_DURING_DAY = 0;
    const TIME_AFTER_AWAKE = 1;
    const TIME_BREAKFAST = 2;
    const TIME_LUNCH = 3;
    const TIME_DINNER = 4;
    const TIME_BEFORE_BED = 5;

    const FREQUENCY_EVERY_DAY = 1;
    const FREQUENCY_EVERY_OTHER_DAY = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'visit_id',
        'type',
        'name',
        'details',
        'amount',
        'description',
        'time_type',
        'frequency_type',
        'date_from',
        'date_to',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'visit_id' => 'integer',
        'type' => 'integer',
        'amount' => 'float',
        'time_type' => 'integer',
        'frequency_type' => 'integer',
        'date_from' => 'date',
        'date_to' => 'date',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_MEDICATION,
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
        'details',
        'description',
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
    public static function typeStatuses()
    {
        return [
            self::TYPE_MEDICATION => __('Medication'),
            self::TYPE_FOOD => __('Food'),
            self::TYPE_DRINK => __('Drink'),
        ];
    }

    /**
     * @return array
     */
    public static function typeBadgeClasses()
    {
        return [
            self::TYPE_MEDICATION => 'success',
            self::TYPE_FOOD => 'primary',
            self::TYPE_DRINK => 'info',
        ];
    }

    /**
     * @return array
     */
    public static function timeTypeStatuses()
    {
        return [
            self::TIME_DURING_DAY => __('During The Day'),
            self::TIME_AFTER_AWAKE => __('After Waking Up'),
            self::TIME_BREAKFAST => __('Breakfast Time'),
            self::TIME_LUNCH => __('Lunch Time'),
            self::TIME_DINNER => __('Dinner Time'),
            self::TIME_BEFORE_BED => __('Before Going to Bed'),
        ];
    }

    /**
     * @return array
     */
    public static function timeTypeBadgeClasses()
    {
        return [
            self::TIME_DURING_DAY => 'warning',
            self::TIME_AFTER_AWAKE => 'primary',
            self::TIME_BREAKFAST => 'primary',
            self::TIME_LUNCH => 'success',
            self::TIME_DINNER => 'info',
            self::TIME_BEFORE_BED => 'info',
        ];
    }

    /**
     * @return array
     */
    public static function frequencyTypeStatuses()
    {
        return [
            self::FREQUENCY_EVERY_DAY => __('Every day'),
            self::FREQUENCY_EVERY_OTHER_DAY => __('Every Other Day'),
        ];
    }

    /**
     * @return array
     */
    public static function frequencyTypeBadgeClasses()
    {
        return [
            self::FREQUENCY_EVERY_DAY => 'info',
            self::FREQUENCY_EVERY_OTHER_DAY => 'success',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptionTasks()
    {
        return $this->hasMany(PrescriptionTask::class, 'prescription_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * @return mixed
     */
    public function getTypeTextAttribute()
    {
        return static::typeStatuses()[$this->type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getTypeBadgeClassAttribute()
    {
        return static::typeBadgeClasses()[$this->type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getTimeTypeTextAttribute()
    {
        return static::timeTypeStatuses()[$this->time_type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getTimeTypeBadgeClassAttribute()
    {
        return static::timeTypeBadgeClasses()[$this->time_type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getFrequencyTypeTextAttribute()
    {
        return static::frequencyTypeStatuses()[$this->frequency_type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getFrequencyTypeBadgeClassAttribute()
    {
        return static::frequencyTypeBadgeClasses()[$this->frequency_type] ?? null;
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
    public function getFullPrescriptionAttribute()
    {
        $fields = [
            $this->name,
            $this->amount,
            $this->details,
        ];

        return implode(", ", array_filter($fields));
    }

    /**
     * @return array
     */
    public static function list()
    {
        return static::defaultOrder()->get()->pluck('fullPrescription', 'id')->toArray();
    }
}
