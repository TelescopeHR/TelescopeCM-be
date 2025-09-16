<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
    ];

    /**
     * Get the visits associated with this visit type.
     */
    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'visit_visit_types');
    }
}
