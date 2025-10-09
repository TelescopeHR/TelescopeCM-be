<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\CarePlan;
use App\Traits\FileTrait;
use App\Traits\UserTrait;
use App\Traits\OrderTrait;
use App\Traits\FilterTrait;
use Illuminate\Support\Str;
use App\Traits\CaptionTrait;
use App\Traits\TimestampTrait;
use App\Services\AddressService;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\FilterByCompanyTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

//use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use PivotEventTrait;
    use Notifiable;
    // use FilterByCompanyTrait;

    // //use GlobalSearchable;
    // use UserTrait;
    // use TimestampTrait;
    // use FileTrait;
    // use CaptionTrait;
    // use OrderTrait;
    // use FilterTrait;
    use HasApiTokens;

    const GENDER_NOT_SET = null;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const STATUS_BLOCKED = -1;
    const STATUS_NEW = 0;
    const STATUS_VERIFIED = 1;

    const TOKEN_EXPIRE_VALUE = 2;

    /**
     * @var string
     */
    public static $title = 'fullName';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'middle_name',
        'last_name',
        'company_id',
        'country_id',
        'gender',
        'birthday',
        'avatar',
        'manual_client_id',
        'email',
        'password',
        'status',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'instructions',
        'from_created_at',
        'to_created_at',
        'last_login_at',
        'created_by',
    ];

    protected $dates = ['last_login_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'country_id' => 'integer',
        'birthday' => 'date',
        'status' => 'integer',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'gender' => 'integer',
        'from_created_at' => 'from_date',
        'to_created_at' => 'to_date',
    ];

    /**
     * @var array
     */
    protected $files = [
        'avatar' => 'image',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_NEW,
    ];

    /**
     * @var array
     */
    protected $order = [
        'created_at' => 'desc'
    ];

    //  protected $appends = ['full_address'];

    /**
     * @var array
     */
    protected $search = [
        'email',
        'first_name',
        'last_name',
        'zip',
        'city',
        'address',
        'phone',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'email',
        'id',
    ];

    public function __construct(array $attributes = [])
    {
        static::saving(function ($model) {
            $companyId = (int)request('company_id');
            $user = Auth::user();

            if (empty($companyId) && !empty($user) && !$user->isSuperAdmin() && !$model->exists) {
                $model->company_id = $user->company_id;
            }
        });

        parent::__construct($attributes);
    }

    /**
     * @return array
     */
    public static function genders()
    {
        return [
            self::GENDER_NOT_SET => __('Not Set'),
            self::GENDER_MALE => __('Male'),
            self::GENDER_FEMALE => __('Female'),
        ];
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_BLOCKED => __('Blocked'),
            self::STATUS_NEW => __('New'),
            self::STATUS_VERIFIED => __('Verified'),
        ];
    }

    /**
     * @return array
     */
    public static function statusBadgeClasses()
    {
        return [
            self::STATUS_BLOCKED => 'danger',
            self::STATUS_NEW => 'warning',
            self::STATUS_VERIFIED => 'success',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(Setting::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptionTasks()
    {
        return $this->hasMany(PrescriptionTask::class, 'patient_id')->defaultOrder();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientVisits()
    {
        return $this->hasMany(Visit::class, 'client_id')->defaultOrder();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function careWorkerVisits()
    {
        return $this->hasMany(Visit::class, 'care_worker_id')->defaultOrder();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recordedTimeEntries()
    {
        return $this->hasMany(VisitTimeEntry::class, 'care_worker_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * return void
     */
    public function getRolesTextAttribute()
    {
        return implode(', ', $this->roles->pluck('name')->toArray());
    }

    /**
     * return void
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(Role::ROLE_SUPER_ADMIN);
    }

    /**
     * Check if the user has any of the given roles.
     * @param $roles
     * @return bool
     */
    public function hasActiveRoles($roles): bool
    {
        $userRoles = $this->roles->pluck('name')->toArray();

        if (is_array($roles)) {
            return !empty(array_intersect($roles, $userRoles));
        }

        return in_array($roles, $userRoles);
    }

    /**
     * return void
     */
    public function isCompanyAdmin()
    {
        return $this->hasRole(Role::ROLE_COMPANY_ADMIN);
    }

    /**
     * return void
     */
    public function isPatient()
    {
        return $this->hasRole(Role::ROLE_PATIENT);
    }

    /**
     * return void
     */
    public function isFriendOrFamily()
    {
        return $this->hasRole(Role::ROLE_FRIEND_OR_FAMILY);
    }

    /**
     * return void
     */
    public function isCareWorker()
    {
        return $this->hasRole(Role::ROLE_CARE_WORKER);
    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return null !== $this->roles->where('name', $role)->first();
    }

    /**
     * @param $role
     * @return void
     */
    public function saveRole($role)
    {
        if ($role == Role::ROLE_ID_SUPER_ADMIN
            && !Auth::user()->isSuperAdmin()) {
            return;
        }

        $this->roles()->sync([$role]);
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * @param $permission
     * @return mixed
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->contains($permission);
    }

    /**
     * @param $itemId
     * @return boolean
     */
    public function hasСarePlanItem($itemId)
    {
        // To-Do
        return false;
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @param $query
     * @param $role
     * @return mixed
     */
    public function scopeFilterRole($query, $role)
    {
        if (empty($role)) {
            return $query;
        }

        return $query->whereHas('roles', function ($query) use ($role) {
            $query->where('role_id', $role);
        });
    }

    /**
     * @param $query
     * @param $roleType
     * @return mixed
     */
    public function scopeFilterRoleType($query, $roleType)
    {
        if (empty($roleType) || $roleType != 'employee') {
            return $query;
        }

        return $query->whereHas('roles', function ($query) {
            $query->whereIn('role_id', [Role::ROLE_ID_COMPANY_ADMIN, Role::ROLE_ID_CARE_WORKER]);
        });
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (empty($this->first_name) && empty($this->last_name)) {
            return null;
        }

        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get full address
     * @return string|null
     */
    public function getFullAddressAttribute()
    {
        if (
            empty($this->address) &&
            empty($this->city) &&
            empty($this->state) &&
            empty($this->zip) &&
            empty($this->country_id)
        ) {
            return null;
        }

        $stateName = null;
        if (!empty($this->state)) {
            $stateName = AddressService::STATES[$this->state] ?? $this->state;
        }

        $parts = array_filter([
            $this->address,
            $this->city,
            $stateName,
            $this->zip,
            optional($this->country)->name,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get full state
     * @return mixed|string|null
     */
    public function getFullStateAttribute()
    {
        if (empty($this->state)) {
            return null;
        }

        return AddressService::STATES[$this->state] ?? $this->state;
    }

    /**
     * Get last name and first name
     * @return string|null
     */
    public function getLastFirstNameAttribute()
    {
        if (empty($this->last_name) && empty($this->first_name)) {
            return null;
        }

        return trim("{$this->last_name}, {$this->first_name}");
    }

    /**
     * @return string
     */
    public function getLetterNameAttribute()
    {
        return mb_substr($this->first_name, 0, 1);
    }

    /**
     * @return mixed
     */
    public function getGenderTextAttribute()
    {
        return $this::genders()[$this->gender] ?? null;
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

    /**
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function savePassword($password)
    {
        $this->password = Hash::make($password);

        return $this->save();
    }

    /**
     * @throws \Exception
     */
    public function updateLastLogin()
    {
        $this->last_login_at = Carbon::now();
        $this->save();
    }

    /**
     * @return array
     */
    public static function list()
    {
        return static::defaultOrder()->pluck(static::$title, 'id')->toArray();
    }

    /**
     * @return array
     */
    public static function flippedList()
    {
        return array_flip(static::list());
    }

    /**
     * @param $roleId
     * @return mixed
     */
    public static function listForRole($roleId)
    {
        $each = Gate::check('user.each');

        return static::filterRole($roleId)
            ->filterByCompany(!$each)
            ->defaultOrder()
            ->get()
            ->pluck(static::$title, 'id')
            ->toArray();
    }

    /**
     * @return mixed
     */
    public static function companyAdmins()
    {
        return self::listForRole(Role::ROLE_ID_COMPANY_ADMIN);
    }

    /**
     * @return mixed
     */
    public static function patients()
    {
        return self::listForRole(Role::ROLE_ID_PATIENT);
    }

    /**
     * @return mixed
     */
    public static function careWorkers()
    {
        return self::listForRole(Role::ROLE_ID_CARE_WORKER);
    }

    /**
     * @param $roleName
     * @return mixed
     */
    public static function roleRecords($roleName)
    {
        $role = Role::where('name', $roleName)
            ->firstOrFail();

        return $role->users;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addedRoles()
    {
        return $this->hasMany(Role::class, 'created_by');
    }

    /**
     * @param Builder $query
     * @param string $attribute
     * @param string $value
     * @return Model|Builder|null
     */
    public function scopeByAttribute(Builder $query, string $attribute, string $value): Model|Builder|null
    {
        return $query->where($attribute, $value)->first();
    }

    /**
     * Get the URL for the user's avatar.
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        return asset('storage/files/user/' . $this->id . '/' . $this->avatar);
    }

    /**
     * Get the custom statuses for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customStatuses()
    {
        return $this->belongsToMany(CustomStatus::class, 'user_custom_statuses')
            ->withTimestamps();
    }

    /**
     * Check if the user has a specific custom status.
     *
     * @param string $statusName
     * @return bool
     */
    public function hasCustomStatus(string $statusName): bool
    {
        return $this->customStatuses()->where('name', $statusName)->exists();
    }

    /**
     * Get the care plans for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carePlans()
    {
        return $this->belongsToMany(CarePlan::class, 'user_care_plans')
            ->withTimestamps();
    }

    public function userCarePlan()
    {
        return $this->hasOne(UserCarePlan::class);
    }

    /**
     * Create an authentication token with expiration.
     *
     * @param string $tokenName
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createAuthToken(string $tokenName = 'auth_token')
    {
        return $this->createToken($tokenName, expiresAt: now()->addHours(self::TOKEN_EXPIRE_VALUE));
    }

    public function clientProfile(): HasOne
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function clientMedical(): HasOne
    {
        return $this->hasOne(ClientMedical::class);
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function shiftNotes(): HasMany
    {
        return $this->hasMany(ShiftNote::class);
    }

    public function employeeShiftNotes(): HasMany
    {
        return $this->hasMany(ShiftNote::class, 'created_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = (string) Str::orderedUuid();
        });
    }
}
