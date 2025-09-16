<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use App\Traits\TypeTrait;

class Role extends BaseModel
{
    use CreatedByTrait;
    use TypeTrait;

    const TYPE_CUSTOM = 0;
    const TYPE_SYSTEM = 1;

    const ROLE_SUPER_ADMIN = 'Super Admin';
    const ROLE_COMPANY_ADMIN = 'Company Admin';
    const ROLE_CARE_WORKER = 'Employee (Care Worker)';
    const ROLE_PATIENT = 'Patient (Client)';
    const ROLE_FRIEND_OR_FAMILY = 'Friend or Family';
  //  const ROLE_COMPANY_EMPLOYEE = 'Company Employee';

    const ROLE_DEMO_USER = 'Demo';

    const ROLE_ID_SUPER_ADMIN = 1;
    const ROLE_ID_COMPANY_ADMIN = 2;
    const ROLE_ID_CARE_WORKER = 3;
    const ROLE_ID_PATIENT = 4;
 //   const ROLE_ID_FRIEND_OR_FAMILY = 5;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_CUSTOM,
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
    public static function types()
    {
        return [
            self::TYPE_CUSTOM => __('Custom'),
            self::TYPE_SYSTEM => __('System'),
        ];
    }

    /**
     * @return array
     */
    public static function typeBadgeClasses()
    {
        return [
            self::TYPE_CUSTOM => 'info',
            self::TYPE_SYSTEM => 'success',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    /**
     * @param $unit_id
     * @param $action
     * @return bool
     */
    public function hasPermission($unit_id, $action)
    {
        return null !== $this->permissions()->where([
                'unit_id' => $unit_id,
                'action' => $action,
            ])->first();
    }
}
