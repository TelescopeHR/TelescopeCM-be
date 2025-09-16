<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class VisitDocument extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'visit_id',
        'name',
        'file',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'visit_id' => 'integer',
    ];

    /**
     * @var array
     */
    protected $files = [
        'file' => 'file',
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit()
    {
        return $this->belongsTo(visit::class);
    }
}
