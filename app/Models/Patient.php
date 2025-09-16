<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (empty($this->first_name) && empty($this->last_name)) {
            return null;
        }

        return "{$this->last_name} {$this->first_name} {$this->middle_name}";
    }

    /**
     * @return string
     */
    public function getLetterNameAttribute()
    {
        return mb_substr($this->first_name, 0, 1);
    }

    /**
     * @return mixed
     */
    public function getGenderTextAttribute()
    {
        return $this::genders()[$this->gender] ?? null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            0 => "On Hold",
            1 => "Pending",
            2 => "Active",
            3 => "Expired",
            4 => "Hospitalized",
            5 => "Rejected",
        ][$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return [
            0 => 'warning',
            1 => 'info',
            2 => 'success',
            3 => 'secondary',
            4 => 'danger',
            5 => 'dark',
        ][$this->status] ?? 'light';
    }

    public function getAdmittedLabelAttribute(): string
    {
        return ((int) $this->admitted == 1) ? "Yes" : "No"; 
    }

    /**
     * @param $itemId
     * @return boolean
     */
    public function hasСarePlanItem($itemId)
    {
        // To-Do
        return false;
    }
}
