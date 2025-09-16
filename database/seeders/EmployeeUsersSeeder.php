<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class EmployeeUsersSeeder extends Seeder
{
    public function run(): void
    {
        $date = Carbon::now();

        $patientRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_CARE_WORKER, 'name' => Role::ROLE_CARE_WORKER, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_CARE_WORKER, 'name' => Role::ROLE_CARE_WORKER, 'type' => Role::TYPE_SYSTEM]
        );

        for ($i = 1; $i <= 50; $i++) {
            $email = "employee{$i}@careworker.com";
            $phone = "876543" . str_pad($i, 4, '0', STR_PAD_LEFT); // Пример: 8765430001...0050

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'email' => $email,
                    'password' => Hash::make('1234567890'),
                    'first_name' => 'Employee',
                    'middle_name' => 'Middle',
                    'last_name' => "CareWorker{$i}",
                    'birthday' => '1990-02-03',
                    'company_id' => 1,
                    'country_id' => $i,
                    'zip' => '12345',
                    'city' => 'NY',
                    'address' => $i . ' Wall St',
                    'phone' => $phone,
                    'state' => 'NY',
                    'instructions' => 'Please review the assigned tasks for today, ensure all safety protocols are followed, and submit your daily report before 5 PM. Contact your supervisor if any issues arise during your shift.',
                    'gender' => 1,
                    'status' => 1,
                    'email_verified_at' => $date,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]
            );

            if (!$user->employeeProfile) {
                $user->employeeProfile()->create([
                    'manual_employee_id' => '123456789',
                    'employee_status' => 1,
                    'social_security' => 123456789,
                    'hire_date' => '2020-02-05',
                    'application_date' => '2020-02-06',
                    'orientation_date' => '2020-03-06',
                    'signed_job_description_date' => '2020-02-07',
                    'signed_policy_procedure_date' => '2020-02-08',
                    'evaluated_assigned_date' => '2020-02-15',
                    'last_evaluation_date' => '2020-02-09',
                    'termination_date' => '2020-02-10',
                    'number_of_references' => 5,
                ]);
            }
            $user->addedRoles()->saveMany([$patientRole]);

            if (!$patientRole->users->contains($user->id)) {
                $patientRole->users()->attach($user);
            }
        }
    }
}
