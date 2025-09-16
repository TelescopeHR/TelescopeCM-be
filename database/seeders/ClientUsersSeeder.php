<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ClientUsersSeeder extends Seeder
{
    public function run(): void
    {
        $date = Carbon::now();

        $patientRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_PATIENT, 'name' => Role::ROLE_PATIENT, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_PATIENT, 'name' => Role::ROLE_PATIENT, 'type' => Role::TYPE_SYSTEM]
        );

        for ($i = 1; $i <= 50; $i++) {
            $email = "patient{$i}@client.com";
            $phone = "12345678" . str_pad($i, 2, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'email' => $email,
                    'password' => Hash::make('1234567890'),
                    'first_name' => 'Patient',
                    'middle_name' => 'Middle',
                    'last_name' => "Client{$i}",
                    'birthday' => '1980-01-01',
                    'company_id' => 1,
                    'country_id' => $i,
                    'zip' => '12345',
                    'city' => 'NY',
                    'address' => 'New Street, ' . $i,
                    'phone' => $phone,
                    'state' => 'NY',
                    'instructions' => 'Drink water like it’s your new hobby. Your body will thank you!',
                    'gender' => 1,
                    'status' => 1,
                    'email_verified_at' => $date,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]
            );

            // Create client profile
            if (!$user->clientProfile) {
                $user->clientProfile()->create([
                    'manual_client_id' => '1234567',
                    'client_status' => 1,
                    'social_security' => 123456789,
                ]);
            }

            // Create client medical info
            if (!$user->clientMedical) {
                $user->clientMedical()->create([
                    'manual_medical_id' => '123456789',
                    'admitted_at' => '2022-01-01',
                    'living_with' => 1,
                    'able_to_respond' => 1,
                    'allergies' => 'Allergies',
                    'classification' => 1,
                    'condition' => 1,
                    'priority' => 1,
                    'dnr' => 1,
                    'medical_instructions' => 'Medical instructions',
                ]);
            }

            $user->addedRoles()->saveMany([$patientRole]);

            if (!$patientRole->users->contains($user->id)) {
                $patientRole->users()->attach($user);
            }
        }
    }
}
