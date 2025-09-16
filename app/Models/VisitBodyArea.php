<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class VisitBodyArea extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var string
     */
    public static $title = 'description';

    /**
     * @var array
     */
    protected $fillable = [
        'visit_id',
        'area_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'visit_id' => 'integer',
        'area_id' => 'integer',
    ];

    /**
     * @var array
     */
    protected $search = [
        'description',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'description',
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(BodyArea::class, 'area_id');
    }
}
