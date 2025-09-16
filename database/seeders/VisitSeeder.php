<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Visit;
use Illuminate\Support\Arr;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_PATIENT);
        })->get();

        $employee = User::where('email', 'care.worker@gmail.com')->first();

        foreach ($users as $client) {
            $schedule = Schedule::where('patient_id', $client->id)->first();

            if ($schedule) {

                // Create 5 visits per client (you can change this)
                foreach (range(1, 10) as $i) {
                    // Define unique keys for identifying existing visits
                    $date = now()->addDays(rand(-30, 30))->toDateString();
                    $timeIn = now()->setTime(rand(8, 10), 0)->format('H:i');
                    Visit::updateOrCreate(
                        [
                            'client_id' => $client->id,
                            'date_at'   => $date,
                            'time_in'   => $timeIn,
                        ],
                        [
                            'care_worker_id' => $employee->id,
                            'schedule_id'    => $schedule->id,
                            'type'           => Arr::random(['Employee', 'Orientation', 'Supervisor']),
                            'pay_rate'       => rand(2000, 10000),
                            'time_out'       => now()->setTime(rand(16, 18), 0)->format('H:i'),
                            'verified_in'    => now()->setTime(rand(12, 14), 0)->format('H:i'),
                            'verified_out'   => now()->setTime(rand(16, 18), 0)->format('H:i'),
                        ]
                    );
                }
            }
        }
    }
}
