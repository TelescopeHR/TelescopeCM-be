<?php

namespace App\Models;

use App\Traits\CreatedByTrait;

class Permission extends BaseModel
{
    use CreatedByTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'unit_id',
        'action',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'unit_id' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * @var array
     */
    protected $search = [
        'action',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'action',
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @param $role_id
     * @return bool
     */
    public function hasRole($role_id)
    {
        return in_array($role_id, $this->roles->pluck('id')->toArray());
    }

    /**
     * return void
     */
    public function getRolesTextAttribute()
    {
        return implode(', ', $this->roles->pluck('name')->toArray());
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return implode('.', array_filter([optional($this->unit)->slug, $this->action]));
    }

    /**
     * @return array
     */
    public static function list()
    {
        $list = [];
        $models = static::with('unit')->get();

        foreach ($models as $model) {
            $list[$model->id] = $model->name;
        }

        return $list;
    }
}
