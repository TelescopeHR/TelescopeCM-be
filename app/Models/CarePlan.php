<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarePlan extends Model
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
     * The users that belong to the care plan.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_care_plans')
            ->withTimestamps();
    }

    /**
     * The guidelines that belong to the care plan.
     */
    public function guidelines(): BelongsToMany
    {
        return $this->belongsToMany(Guideline::class, 'guideline_care_plans')
            ->withTimestamps();
    }
}
