<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HelpType extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['slug', 'title'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(200)->height(200);
    }

    /**
     * Get the visits that belong to the help type.
     */
    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'visit_help_types')->withTimestamps();
    }
}
