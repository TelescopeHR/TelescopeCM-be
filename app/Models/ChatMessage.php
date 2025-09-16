<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class ChatMessage extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var string
     */
    public static $title = 'message';

    /**
     * @var array
     */
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'chat_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * @var array
     */
    protected $search = [
        'message',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'message',
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
