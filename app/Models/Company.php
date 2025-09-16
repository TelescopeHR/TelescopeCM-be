<?php

namespace App\Models;

use Auth;
use CompanySetting;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends BaseModel
{
    //use CreatedByTrait;

    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var array
     */
    protected $order = [
        'created_at' => 'desc',
        'id' => 'desc'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * @var array
     */
    protected $search = [
        'name',
    ];

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_BLOCKED => __('Blocked'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_BLOCKED => 'danger',
            self::STATUS_ACTIVE => 'success',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return mixed
     */
    public function admins()
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($query) {
            $query->where('role_id', Role::ROLE_COMPANY_ADMIN);
        })->get();
    }

    /**
     * @return mixed
     */
    public function getStatusTextAttribute()
    {
        return $this::statuses()[$this->status] ?? null;
    }

    /**
     * @return mixed
     */
    public function getStatusBadgeClassAttribute()
    {
        return static::statusBadgeClasses()[$this->status] ?? null;
    }
}
