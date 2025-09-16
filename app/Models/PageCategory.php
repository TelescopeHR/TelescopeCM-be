<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class PageCategory extends BaseModel
{
    use CreatedByTrait;

    const CATEGORY_BLOG = 1;

    /**
     * @var string
     */
    protected $table = 'page_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
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
        'created_by' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class, 'parent_id');
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
