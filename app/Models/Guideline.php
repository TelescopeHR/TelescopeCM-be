<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guideline extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The care plans that belong to the guideline.
     */
    public function carePlans(): BelongsToMany
    {
        return $this->belongsToMany(CarePlan::class, 'guideline_care_plans')
            ->withTimestamps();
    }
}
