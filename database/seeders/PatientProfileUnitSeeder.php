<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PatientProfileUnitSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $categoryId = DB::table('unit_categories')
            ->where('name', 'Mobile API')
            ->value('id');

        $parentUnitId = DB::table('units')
            ->where('slug', 'mobile-api')
            ->value('id');

        $patientProfileUnitId = DB::table('units')
            ->where('slug', 'mobile-api.patientProfile')
            ->value('id');

        if (! $patientProfileUnitId && $categoryId && $parentUnitId) {
            $patientProfileUnitId = DB::table('units')->insertGetId([
                'category_id' => $categoryId,
                'parent_id' => $parentUnitId,
                'name' => 'API Patient Profile',
                'slug' => 'mobile-api.patientProfile',
                'icon_class' => 'fa fa-user',
                'visible' => false,
                'sorting' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! $patientProfileUnitId) {
            return;
        }

        $permissionExists = DB::table('permissions')
            ->where('unit_id', $patientProfileUnitId)
            ->where('action', 'view')
            ->exists();

        if (! $permissionExists) {
            DB::table('permissions')->insert([
                'unit_id' => $patientProfileUnitId,
                'action' => 'view',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
