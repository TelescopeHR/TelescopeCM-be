<?php

namespace App\Models;

class Country extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'phone_code',
        'vat_rate',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_code' => 'integer',
        'vat_rate' => 'integer',
    ];

    /**
     * @var array
     */
    protected $order = [
        'name' => 'asc',
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
        'phone_code',
        'vat_rate',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
