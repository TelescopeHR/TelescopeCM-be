<?php

namespace App\Models;

class UnitCategory extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'visible',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible' => 'boolean',
        'sorting' => 'integer',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'visible' => true,
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany(Unit::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visibleUnits()
    {
        return $this->hasMany(Unit::class, 'category_id')
            ->visible()
            ->orderBy('sorting', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topLevelUnits()
    {
        return $this->hasMany(Unit::class, 'category_id')
            ->orderBy('sorting')
            ->where(['parent_id' => null]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }
}
