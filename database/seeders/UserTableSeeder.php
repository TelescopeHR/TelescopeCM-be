<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     *
     */
    public function run()
    {
        // User::truncate();

        $date = new \DateTime();

        User::updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'email' => 'admin@admin.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'zip' => '12345',
            'city' => 'New York',
            'address' => 'Times Square',
            'state' => 'NY',
            'birthday' => '1980-01-01',
            'phone' => '+1234567894',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $date = $date->add(new \DateInterval('PT1S'));

        User::updateOrCreate([
            'email' => 'tanya.v.nazarchuk@gmail.com',
        ], [
            'email' => 'tanya.v.nazarchuk@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Tanya',
            'last_name' => 'Nazarchuk',
            'zip' => '6900',
            'city' => 'Zaporozie',
            'address' => 'Ivanova, 11/12',
            'state' => 'NY',
            'phone' => '+380968308708',
            'birthday' => '1980-01-01',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $date = $date->add(new \DateInterval('PT1S'));

        User::updateOrCreate([
            'email' => 'company.admin@gmail.com',
        ], [
            'email' => 'company.admin@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Agency',
            'last_name' => 'Company Admin',
            'company_id' => 1,
            'country_id' => 1,
            'zip' => '12345',
            'city' => 'NY',
            'address' => 'New Street, 11/12',
            'state' => 'NY',
            'birthday' => '1980-01-01',
            'phone' => '1234567893',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        User::updateOrCreate([
            'email' => 'company.admin2@gmail.com',
        ], [
            'email' => 'company.admin2@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Agency 2',
            'last_name' => 'Company Admin 2',
            'company_id' => 2,
            'country_id' => 1,
            'birthday' => '1980-01-01',
            'zip' => '12345',
            'city' => 'NY',
            'address' => 'New Street 2, 11/12',
            'state' => 'NY',
            'phone' => '1234567895',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $date = $date->add(new \DateInterval('PT1S'));

        $employee = User::updateOrCreate([
            'email' => 'care.worker@gmail.com',
        ], [
            'email' => 'care.worker@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Employee',
            'last_name' => 'Care Worker',
            'company_id' => 1,
            'country_id' => 10,
            'zip' => '12345',
            'city' => 'NY',
            'address' => '742 Evergreen Terrace',
            'state' => 'NY',
            'birthday' => '1980-01-01',
            'phone' => '1234567892',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        if (!$employee->employeeProfile) {
            $employee->employeeProfile()->create([
                'manual_employee_id' => '123456789',
                'employee_status' => 1,
                'social_security' => 123456789,
                'hire_date' => '2020-02-05',
                'application_date' => '2022-03-06',
                'orientation_date' => '2023-05-06',
                'signed_job_description_date' => '2020-02-07',
                'signed_policy_procedure_date' => '2020-02-08',
                'evaluated_assigned_date' => '2020-02-15',
                'last_evaluation_date' => '2020-02-09',
                'termination_date' => '2020-02-10',
                'number_of_references' => 1,
            ]);
        }

        $date = $date->add(new \DateInterval('PT1S'));

        $user1 = User::updateOrCreate([
            'email' => 'patient.client@gmail.com',
        ], [
            'email' => 'patient.client@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Patient',
            'last_name' => 'Client',
            'birthday' => '1980-01-01',
            'company_id' => 1,
            'country_id' => 5,
            'zip' => '12345',
            'city' => 'NY',
            'address' => '221B Baker Street',
            'phone' => '1234567891',
            'state' => 'CA',
            'instructions' => 'Follow the plan, rest well, and remember — ice cream is totally medicinal… probably.',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Create client profile
        if (!$user1->clientProfile) {
            $user1->clientProfile()->create([
                'manual_client_id' => '1234567',
                'client_status' => 1,
                'social_security' => 123456789,
            ]);
        }

        if (!$user1->clientMedical) {
            // Create client medical info
            $user1->clientMedical()->create([
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

        $user2 = User::updateOrCreate([
            'email' => 'patient2.client@gmail.com',
        ], [
            'email' => 'patient2.client@gmail.com',
            'password' => bcrypt('1234567890'),
            'first_name' => 'Patient 2',
            'last_name' => 'Client 2',
            'birthday' => '1980-01-01',
            'company_id' => 1,
            'country_id' => 2,
            'zip' => '12345',
            'city' => 'NY',
            'address' => '500 S Buena Vista Street',
            'phone' => '1234567291',
            'state' => 'AK',
            'instructions' => 'Take short walks, breathe fresh air, and smile at random squirrels.',
            'gender' => 1,
            'status' => 1,
            'email_verified_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        if (!$user2->clientProfile) {
            // Create client profile
            $user2->clientProfile()->create([
                'manual_client_id' => '1234567',
                'client_status' => 1,
                'social_security' => 123456789,
            ]);
        }

        if (!$user2->clientMedical) {
            // Create client medical info
            $user2->clientMedical()->create([
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
    }
}
