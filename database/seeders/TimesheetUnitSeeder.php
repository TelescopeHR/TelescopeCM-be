<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TimesheetUnitSeeder extends Seeder
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

        $timesheetUnitId = DB::table('units')
            ->where('slug', 'mobile-api.timesheet')
            ->value('id');

        if (! $timesheetUnitId && $categoryId && $parentUnitId) {
            $timesheetUnitId = DB::table('units')->insertGetId([
                'category_id' => $categoryId,
                'parent_id' => $parentUnitId,
                'name' => 'API Timesheet',
                'slug' => 'mobile-api.timesheet',
                'icon_class' => 'fa fa-clock',
                'visible' => false,
                'sorting' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! $timesheetUnitId) {
            return;
        }

        $permissionExists = DB::table('permissions')
            ->where('unit_id', $timesheetUnitId)
            ->where('action', 'view')
            ->exists();

        if (! $permissionExists) {
            DB::table('permissions')->insert([
                'unit_id' => $timesheetUnitId,
                'action' => 'view',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
