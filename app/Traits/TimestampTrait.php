<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Trait TimestampTrait
 * @package App\Traits
 */
trait TimestampTrait
{
    /**
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        return !empty($this->created_at)
            ? Carbon::parse($this->created_at)->toFormattedDateString()
            : null;
    }

    /**
     * @return string
     */
    public function getCreatedTimeAttribute()
    {
        return !empty($this->created_at)
            ? Carbon::parse($this->created_at)->toTimeString()
            : null;
    }

    /**
     * @return string
     */
    public function getUpdatedDateAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->toFormattedDateString()
            : null;
    }

    /**
     * @return string
     */
    public function getUpdatedTimeAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->toTimeString()
            : null;
    }

    /**
     * @return null|string
     */
    public function getDiffForHumansAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->diffForHumans()
            : null;
    }

    /**
     * @return int|null
     */
    public function getDiffInDaysAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->diffInDays()
            : null;
    }
}