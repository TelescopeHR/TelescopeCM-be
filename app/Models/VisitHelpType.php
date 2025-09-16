<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitHelpType extends Model
{
    protected $fillable = ['visit_id', 'help_type_id'];

    /**
     * Get the visit that owns the help type.
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Get the help type that belongs to the visit.
     */
    public function helpType()
    {
        return $this->belongsTo(HelpType::class);
    }
}
