<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class Chat extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var string
     */
    public static $title = 'createdBy';

    /**
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'createdBy',
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_users');
    }

    /**
     * @return mixed
     */
    public function getUsersTextAttribute()
    {
        return __('UsersText');
    }
}
