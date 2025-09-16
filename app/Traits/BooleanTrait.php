<?php
namespace App\Traits;

use Arr;
use Str;

trait BooleanTrait
{
    /**
     * @return array
     */
    public static function booleanStatuses()
    {
        return [
            false => __('No'),
            true => __('Yes'),
        ];
    }

    /**
     * @return array
     */
    public static function booleanBadgeClasses()
    {
        return [
            false => 'danger',
            true => 'success',
        ];
    }

    /**
     * @param $field
     * @return null
     */
    public function getBooleanTextAttribute($field)
    {
        $value = (bool) $this->getAttribute($field);

        return static::booleanStatuses()[$value] ?? null;
    }

    /**
     * @param $field
     * @return null
     */
    public function getBooleanBadgeClassAttribute($field)
    {
        $value = (bool) $this->getAttribute($field);

        return static::booleanBadgeClasses()[$value] ?? null;
    }

    /**
     * @return mixed
     */
    public function booleanFields()
    {
        return Arr::where($this->casts, function ($value) {
            return $value == 'boolean';
        });
    }

    /**
     * @param $name
     * @return string\|null
     */
    public function __get($name)
    {
        foreach ($this->booleanFields() as $field => $type) {
            $caption = Str::camel($field);
            if ($name == $caption . 'Text') {
                return $this->getBooleanTextAttribute($field);
            }
            if ($name == $caption . 'BadgeClass') {
                return $this->getBooleanBadgeClassAttribute($field);
            }
        }

        return parent::__get($name);
    }

    /**
     * @param $name
     * @param $arguments
     * @return array
     */
    public function __call($name, $arguments)
    {
        foreach ($this->booleanFields() as $field => $type) {
            if ($name == $field . 'Statuses') {
                return $this->booleanStatuses();
            }
        }

        return parent::__call($name, $arguments);
    }
}