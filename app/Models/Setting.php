<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use App\Traits\TypeTrait;

class Setting extends BaseModel
{
    use CreatedByTrait;
    use TypeTrait;

    const TYPE_CUSTOM = 0;
    const TYPE_SYSTEM = 1;

    const TYPE_STRING = 0;
    const TYPE_TEXT = 1;
    const TYPE_BOOLEAN = 2;
    const TYPE_INTEGER = 3;
    const TYPE_FLOAT = 4;
    const TYPE_EMAIL = 5;

    /**
     * @var string
     */
    public static $title = 'title';

    /**
     * @var array
     */
    public static $items;

    /**
     * @var array
     */
    protected $fillable = [
        'value_type',
        'title',
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'integer',
        'value_type' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_CUSTOM,
        'value_type' => self::TYPE_STRING,
    ];

    /**
     * @var array
     */
    protected $search = [
        'title',
        'key',
        'value',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'title',
        'id',
    ];

    /**
     * @return array
     */
    public static function types()
    {
        return [
            self::TYPE_CUSTOM => __('Custom'),
            self::TYPE_SYSTEM =>  __('System'),
        ];
    }

    /**
     * @return array
     */
    public static function typeBadgeClasses()
    {
        return [
            self::TYPE_CUSTOM => 'info',
            self::TYPE_SYSTEM => 'success',
        ];
    }

    /**
     * @return array
     */
    public static function valueTypes()
    {
        return [
            self::TYPE_STRING => __('String'),
            self::TYPE_TEXT => __('Text'),
            self::TYPE_BOOLEAN => __('Boolean'),
            self::TYPE_INTEGER => __('Integer'),
            self::TYPE_FLOAT => __('Float'),
            self::TYPE_EMAIL => __('Email'),
        ];
    }

    /**
     * @return array
     */
    public static function valueTypeBadgeClasses()
    {
        return [
            self::TYPE_STRING => 'info',
            self::TYPE_TEXT => 'info',
            self::TYPE_BOOLEAN => 'primary',
            self::TYPE_INTEGER => 'success',
            self::TYPE_FLOAT => 'success',
            self::TYPE_EMAIL => 'info',
        ];
    }

    /**
     * @return mixed
     */
    public function getValueTypeTextAttribute()
    {
        return static::valueTypes()[$this->value_type] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getValueTypeBadgeClassAttribute()
    {
        return static::valueTypeBadgeClasses()[$this->value_type] ?? null;
    }

    /**
     * @param $key
     * @return null
     */
    public static function getValue($key)
    {
        $items = static::getAllValues();
        $model = $items->where('key', $key)->first();
        $value = optional($model)->value;
        $type = optional($model)->type;

        switch ($type) {
            case self::TYPE_BOOLEAN:
                $value = (bool) $value;
                break;
            case self::TYPE_INTEGER:
                $value = (integer) $value;
                break;
            case self::TYPE_FLOAT:
                $value = (float) $value;
                break;
        }

        return $value;
    }

    /**
     * @return Setting[]|array|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllValues()
    {
        if (empty(static::$items)) {
            static::$items = static::all();
        }

        return static::$items;
    }

    /**
     * @param $name
     * @return \App\Traits\string\|null
     */
    public function __get($name)
    {
        return static::getValue($name)
            ?? parent::__get($name);
    }
}
