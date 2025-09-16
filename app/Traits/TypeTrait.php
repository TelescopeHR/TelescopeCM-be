<?php
namespace App\Traits;

trait TypeTrait
{
    /**
     * @return mixed
     */
    public function getTypeTextAttribute()
    {
        return static::types()[$this->type] ?? null;
    }

    /**
     * @return mixed
     */
    public function getTypeBadgeClassAttribute()
    {
        return static::typeBadgeClasses()[$this->type] ?? null;
    }
}