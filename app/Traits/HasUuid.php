<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::orderedUuid();
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
