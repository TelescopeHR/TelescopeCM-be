<?php

namespace App\Models;

class BodyArea extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
    ];
}
