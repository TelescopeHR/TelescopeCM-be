<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AssignAllMobileApiPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $roleNames = [
            Role::ROLE_SUPER_ADMIN,
            Role::ROLE_COMPANY_ADMIN,
            Role::ROLE_CARE_WORKER,
        ];

        $permissions = DB::table('permissions')
            ->join('units', 'permissions.unit_id', '=', 'units.id')
            ->where('units.slug', 'like', 'mobile-api.%')
            ->select('permissions.id as permission_id')
            ->pluck('permission_id')
            ->unique();

        if ($permissions->isEmpty()) {
            return;
        }

        foreach ($roleNames as $roleName) {
            $roleId = DB::table('roles')
                ->where('name', $roleName)
                ->value('id');

            if (! $roleId) {
                continue;
            }

            foreach ($permissions as $permissionId) {
                $exists = DB::table('role_permission')
                    ->where('role_id', $roleId)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (! $exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }
}
