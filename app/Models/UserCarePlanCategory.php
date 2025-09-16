<?php

namespace App\Models;

class UserCarePlanCategory extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'user_care_plan_id',
    ];

    // /**
    //  * @var array
    //  */
    // protected $search = [
    //     'notes',
    // ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CarePlanCategory::class);
    }

    public function item()
    {
        return $this->belongsTo(CarePlanItem::class, 'item_id');
    }
}

