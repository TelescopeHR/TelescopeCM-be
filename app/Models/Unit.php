<?php

namespace App\Models;

class Unit extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'slug',
        'icon_class',
        'visible',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'parent_id' => 'integer',
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
        'slug',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(UnitCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * @return array
     */
    public static function visibleList()
    {
        return static::visible()->pluck('visible', 'slug')->toArray();
    }

    /**
     * @return array
     */
    public static function topLevelList()
    {
        return static::defaultOrder()->topLevel()->pluck(static::$title, 'id')->toArray();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTopLevel($query)
    {
        return $query->where('parent_id', null);
    }

    /**
     * @return string
     */
    public function getFirstTitleAttribute()
    {
        $position = strpos($this->name, " ");

        return !$position
            ? $this->name
            : substr($this->name, 0, $position);
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return trim(substr($this->name, strpos($this->name, " ")));
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function getRecordBySlug($slug)
    {
        return static::visible()
            ->where('slug', $slug)
            ->first();
    }
}
