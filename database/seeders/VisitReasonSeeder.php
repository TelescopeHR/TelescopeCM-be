<?php

namespace Database\Seeders;

use App\Models\VisitReason;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VisitReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisitReason::insert([
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC01',
                'name' => 'Mobile App/Device Issue',
                'description' => 'Caregiver’s phone malfunctioned, app crashed, or no signal. Device died, app frozen, or no internet connection',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC02',
                'name' => 'Forgot to Clock In',
                'description' => 'Caregiver forgot to clock in but provided services as scheduled. Human error.',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC03',
                'name' => 'EVV Not Accessible',
                'description' => 'Caregiver couldn’t access the app due to system downtime.	Telescope outage or EVV maintenance',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC04',
                'name' => 'Forgot to Clock Out',
                'description' => 'Caregiver forgot to clock out at visit end. Human error.',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC05',
                'name' => 'Missed Visit with Notification',
                'description' => 'Caregiver notified agency. Documented cancellation',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC06',
                'name' => 'Visit Location Change',
                'description' => 'Visit occurred at alternate location.	Client temporarily at family’s home or facility',
                'created_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'code' => 'RC07',
                'name' => 'Substitute Caregiver',
                'description' => 'Replacement caregiver completed the visit. Backup assigned for shift',
                'created_at' => now(),
            ],
        ]);
    }
}
