<?php

namespace App\Models;

use DB;
use Artisan;
use Rocky\Eloquent\HasDynamicRelation;

class Translation extends BaseModel
{
    use HasDynamicRelation;

    const STATUS_NOT_PUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var string
     */
    protected $table = 'ltm_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'locale',
        'group',
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
        'published' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_NOT_PUBLISHED,
    ];

    /**
     * @var array
     */
    protected $search = [
        'group',
        'key',
        'value',
    ];

    /**
     * @var array
     */
    protected $order = [
        'key' => 'asc',
    ];

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function languages()
    {
        $languages = config('translation-manager.langs');

        return is_array($languages) ? $languages : [];
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_PUBLISHED => __('Not Published'),
            self::STATUS_PUBLISHED => __('Published'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_NOT_PUBLISHED => 'danger',
            self::STATUS_PUBLISHED => 'success',
        ];
    }

    /**
     * Translation constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->initTranslationRelations();

        parent::__construct($attributes);
    }

    /**
     * @return null
     */
    public function initTranslationRelations()
    {
        foreach (static::languages() as $language) {
            static::addDynamicRelation($language, function(self $model) use ($language) {
                return $model->hasOne(static::class, 'key', 'key')->where('locale', $language);
            });
        }
    }

    /**
     * @return mixed
     */
    public static function groupedList()
    {
        return static::groupBy('group', 'key')
            ->select('group', 'key')
            ->with(static::languages());
    }

    /**
     * @return mixed
     */
    public static function groups()
    {
        return static::groupBy('group')
            ->select('group')
            ->pluck('group', 'group')->toArray();
    }

    /**
     * @return array
     */
    public static function locales()
    {
        return static::groupBy('locale')
            ->select('locale')
            ->pluck('locale', 'locale')->toArray();
    }

    /**
     * @param $model
     * @return mixed
     */
    public static function findClone($model)
    {
        return static::where([
            ['locale', $model->locale],
            ['group', $model->group],
            ['key', $model->key],
        ])->first();
    }

    /**
     * @param $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function saveWithRelations($data)
    {
        $status = true;

        foreach (static::languages() as $language) {
            $model = new self;
            $model->fill($data);
            $model->locale = $language;

            if ($this->exists) {
                $model->group = $this->group;
                $model->key = $this->key;
            }

            $model = static::findClone($model) ?? $model;

            if ($model->value == $data[$language] && $this->exists) {
                continue;
            }

            $model->value = $data[$language];
            $model->status = self::STATUS_NOT_PUBLISHED;

            $status = $model->save() && $status;
        }

        return $status;
    }

    /**
     * @return bool
     */
    public function deleteWithRelations()
    {
        $status = true;

        foreach (static::languages() as $language) {
            $id = (int) optional($this->$language)->id;
            if (!empty($id)) {
                $status = static::find($id)->delete() && $status;
            }
        }

        return $status;
    }

    /**
     * @return mixed
     */
    public function getStatusTextAttribute()
    {
        return static::statuses()[$this->status] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getStatusBadgeClassAttribute()
    {
        return static::statusBadgeClasses()[$this->status] ?? null;
    }

    /**
     * @return string
     */
    public function getPublishedAttribute()
    {
        $published = self::STATUS_PUBLISHED;

        foreach (static::languages() as $language) {
            if (optional($this->$language)->status === self::STATUS_NOT_PUBLISHED) {
                $published = self::STATUS_NOT_PUBLISHED;
            }
        }

        return $published;
    }

    /**
     * @param $field
     * @return null
     */
    public function getGroupedValue($field)
    {
        foreach (static::languages() as $language) {
            $value = optional($this->$language)->$field;
            if (!empty($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @return null
     */
    public function getGroupedCreatedAttribute()
    {
        return $this->getGroupedValue('createdDate');
    }

    /**
     * @return null
     */
    public function getGroupedUpdatedAttribute()
    {
        return $this->getGroupedValue('updatedDate');
    }

    /**
     * @return null
     */
    public function getGroupedIdAttribute()
    {
        return $this->getGroupedValue('id');
    }

    public static function exportAll()
    {
        Artisan::call('translations:export {group}', ['group' => '*']);
        DB::table('ltm_translations')->update([
            'status' => self::STATUS_PUBLISHED,
        ]);
    }
}
