<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Class UserPresenter
 * @package App\Presenters
 */
trait UserTrait
{
    /**
     * @return string
     */
    public function getBirthdayDateAttribute()
    {
        return !empty($this->birthday)
            ? Carbon::parse($this->birthday)->toFormattedDateString()
            : null;
    }

    /**
     * @return string
     */
    public function getLastLoginDateAttribute()
    {
        return !empty($this->last_login_at)
            ? Carbon::parse($this->last_login_at)->toFormattedDateString()
            : null;
    }

    /**
     * @return string
     */
    public function getLastLoginTimeAttribute()
    {
        return !empty($this->last_login_at)
            ? Carbon::parse($this->last_login_at)->toTimeString()
            : null;
    }

    /**
     * @return string
     */
    public function getEmailVerifiedDateAttribute()
    {
        return !empty($this->email_verified_at)
            ? Carbon::parse($this->email_verified_at)->toFormattedDateString()
            : null;
    }

    /**
     * @return string
     */
    public function getEmailVerifiedTimeAttribute()
    {
        return !empty($this->email_verified_at)
            ? Carbon::parse($this->email_verified_at)->toTimeString()
            : null;
    }
}