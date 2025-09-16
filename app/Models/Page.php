<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class Page extends BaseModel
{
    use CreatedByTrait;

    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;
    const VISIBLE_LOGGED = 2;
    const VISIBLE_GUEST = 3;

    /**
     * @var string
     */
    public static $title = 'link_name';

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'link_name',
        'slug',
        'content',
        'title',
        'meta_keywords',
        'meta_description',
        'header',
        'visible',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'parent_id' => 'integer',
        'sorting' => 'integer',
        'visible' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * @var array
     */
    protected $files = [
        'image' => 'image',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'visible' => self::VISIBLE_YES,
    ];

    /**
     * @var array
     */
    protected $search = [
        'link_name',
        'slug',
        'content',
        'title',
        'meta_keywords',
        'meta_description',
        'header',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'link_name',
        'id',
    ];

    /**
     * @return array
     */
    public static function visibleStatuses()
    {
        return [
            self::VISIBLE_NO => __('No'),
            self::VISIBLE_YES => __('Yes'),
            self::VISIBLE_LOGGED => __('Logged'),
            self::VISIBLE_GUEST => __('Guest'),
        ];
    }

    /**
     * @return array
     */
    public static function visibleBadgeClasses()
    {
        return [
            self::VISIBLE_NO => 'danger',
            self::VISIBLE_YES => 'success',
            self::VISIBLE_LOGGED => 'warning',
            self::VISIBLE_GUEST => 'warning',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function snippets()
    {
        return $this->belongsToMany(Snippet::class, 'snippet_pages');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PageCategory::class, 'parent_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', self::VISIBLE_YES);
    }

    /**
     * @param $query
     * @param $parentId
     * @return mixed
     */
    public function scopeOfParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * @return mixed
     */
    public function getVisibleTextAttribute()
    {
        $visible = $this->getAttribute('visible');

        return static::visibleStatuses()[$visible] ?? null;
    }

    /**
     * @return mixed
     */
    public function getVisibleBadgeClassAttribute()
    {
        $visible = $this->getAttribute('visible');

        return static::visibleBadgeClasses()[$visible] ?? null;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function getRecordBySlug($slug)
    {
        return static::visible()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * @param $parentId
     * @param $itemsPerPage
     * @return mixed
     */
    public static function categoryRecords($parentId, $itemsPerPage)
    {
        return static::with('createdBy')
            ->visible()
            ->ofParent($parentId)
            ->orderBy('created_at', 'desc')
            ->paginate($itemsPerPage);
    }
}
