<?php
namespace App\Traits;

trait CaptionTrait
{
    /**
     * @return mixed
     */
    public function getCaptionAttribute()
    {
        return $this->getAttribute(static::$title);
    }
}