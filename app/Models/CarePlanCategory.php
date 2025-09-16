<?php

namespace App\Models;

class CarePlanCategory extends BaseModel
{
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
    public function items()
    {
        return $this->hasMany(CarePlanItem::class, 'category_id');
    }
}
