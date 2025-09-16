<?php
namespace App\Traits;

use App\Models\User;
use App\Observers\CreatedByObserver;

trait CreatedByTrait
{
    /**
     * Attaches observer to the model
     *
     * return null
     */
    public static function bootCreatedByTrait()
    {
        static::observe(new CreatedByObserver);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return mixed
     */
    public function getCreatedByTextAttribute()
    {
        return optional($this->createdBy)->fullName;
    }
}
