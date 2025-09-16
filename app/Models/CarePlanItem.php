<?php

namespace App\Models;

class CarePlanItem extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
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
    public function category()
    {
        return $this->belongsTo(CarePlanCategory::class, 'category_id');
    }
}

