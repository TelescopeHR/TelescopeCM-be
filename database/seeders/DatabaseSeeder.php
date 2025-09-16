<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            CountryTableSeeder::class,
            CompanyTableSeeder::class,
            UserTableSeeder::class,
            RoleTableSeeder::class,
            UnitCategoryTableSeeder::class,
            UnitTableSeeder::class,
            PermissionTableSeeder::class,
            SettingTableSeeder::class,
            MoodTypeIconSeeder::class,
            HelpTypeIconSeeder::class,
            //PageTableSeeder::class,
            BodyAreaSeeder::class,
            ScheduleTypeSeeder::class,
            CarePlanCategorySeeder::class,
            CarePlanItemSeeder::class,
            TimesheetUnitSeeder::class,
            PatientProfileUnitSeeder::class,
            AssignAllMobileApiPermissionsSeeder::class,
            UserCarePlanSeeder::class,
            ScheduleSeeder::class,
            VisitSeeder::class,
            ClientUsersSeeder::class,
            EmployeeUsersSeeder::class,
            ShiftNoteSeeder::class
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
