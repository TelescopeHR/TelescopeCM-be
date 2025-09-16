<?php

namespace App\Models;


class UserCarePlan extends BaseModel
{
    /**
     * @var string
     */
    public static $title = 'id';

    /**
     * @var array
    */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * @var array
     */
    protected $search = [
        'emergency_name',
        'emergency_relation',
        'emergency_phone',
        'physician_name',
        'physician_contact',
        'insurance_provider',
        'policy_number',
        'preferred_wakeup_time',
        'preferred_bed_time',
        'preferred_culture',
        'preferred_language',
        'preferred_diet',
        'preferred_activities',
        'requests',
        'care_goals',
        'notes',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}





