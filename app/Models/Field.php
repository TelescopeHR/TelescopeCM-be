<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public const KEY_SHIFT_NOTES = 'shift_notes';
    /**
     * Field name constants - represent the 'name' field in the database
     */
    public const NAME_HELP_BLOCK = 'help_block';
    public const NAME_MOOD_TRACKING = 'mood_tracking';
    public const NAME_NOTES = 'notes';

    protected $fillable = ['key', 'name', 'title', 'required', 'validation_rules'];

    protected $casts = [
        'required' => 'boolean',
    ];

    /**
     * Get fields by key
     *
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByKey(string $key)
    {
        return self::where('key', $key)->get();
    }
}
