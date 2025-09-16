<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitMoodType extends Model
{
    protected $fillable = ['visit_id', 'mood_type_id'];

    /**
     * Get the visit that owns the mood type.
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Get the mood type that belongs to the visit.
     */
    public function moodType()
    {
        return $this->belongsTo(MoodType::class);
    }
}
