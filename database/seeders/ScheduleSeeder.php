<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Schedule;
use App\Models\ScheduleType;
use App\Models\UserCarePlan;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get client
        $admin = User::where('email', 'admin@admin.com')->first();
        $users = User::whereHas('roles', function ($query) {
            $query->where(
                'name',
                Role::ROLE_PATIENT
            );
        })->get();

        $employee = User::where('email', 'care.worker@gmail.com')->first();

        //get schedule types
        $scheduleType = ScheduleType::first();

        foreach($users as $user){
            //get client care pan
            $userCarePlan = UserCarePlan::where('user_id', $user->id)->first();

            // Skip if no care plan exists for this user
            if (!$userCarePlan) {
                continue;
            }

            $schedule = Schedule::updateOrCreate([
                'patient_id' => $user->id,
                'care_plan_id' => $userCarePlan->id 
            ], [
                'patient_id' => $user->id,
                'care_plan_id' => $userCarePlan->id,
                'care_worker_id' => $employee->id,
                'type_id' => $scheduleType->id,
                'date_from' => now()->format('Y-m-d'),
                'date_to' => now()->addMonths(3)->format('Y-m-d'),
                'rate' => 20.00,
                'status' => 1, // Active
                'created_by' => $admin->id,
            ]);

            for ($day = 1; $day <= 7; $day++) {
                    $schedule->times()->updateOrCreate([
                        'schedule_id' => $schedule->id,
                        'day_of_week' => $day
                    ], [
                        'schedule_id' => $schedule->id,
                        'day_of_week' => $day,
                        'time_from' => '08:00:00',
                        'time_to' => '16:00:00',
                        'created_by' => $admin->id,
                    ]);
            }
        }
    }
}
