<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\CreatedByTrait;

class PrescriptionTask extends BaseModel
{
    use CreatedByTrait;

    const STATUS_NA = 0;
    const STATUS_YES = 1;
    const STATUS_NO = -1;

    /**
     * @var string
     */
    public static $title = 'date';

    /**
     * @var array
     */
    protected $fillable = [
        'prescription_id',
        'patient_id',
        'date_at',
        'status',
        'from_date_at',
        'to_date_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'prescription_id' => 'integer',
        'patient_id' => 'integer',
        'date_at' => 'date',
        'status' => 'integer',
        'from_date_at' => 'from_date',
        'to_date_at' => 'to_date',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_NA,
    ];

    /**
     * @var array
     */
    protected $search = [
        'date_at',
    ];

    /**
     * @var array
     */
    protected $order = [
        'date_at' => 'asc',
        'id' => 'asc',
    ];

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_NA => __('N/A'),
            self::STATUS_YES => __('Taken'),
            self::STATUS_NO => __('Not Taken'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_NA => 'secondary',
            self::STATUS_YES => 'success',
            self::STATUS_NO => 'danger',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription()
    {
        return $this->belongsTo(VisitPrescription::class, 'prescription_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
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
     * @param $query
     * @param $patientId
     * @return mixed
     */
    public function scopeOfPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
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
}
