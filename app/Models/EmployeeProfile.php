<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'manual_employee_id',
        'employee_status',
        'social_security',
        'hire_date',
        'application_date',
        'orientation_date',
        'signed_job_description_date',
        'signed_policy_procedure_date',
        'evaluated_assigned_date',
        'last_evaluation_date',
        'termination_date',
        'number_of_references'
    ];

    public const STATUSES = [
        1 => "Active Full",
        2 => "Active Part",
        3 => "Inactive",
        4 => "Terminated",
        5 => "Terminated not eligible"
    ];

    public const EMPLOYEE_LIST_LIMIT = 20;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
