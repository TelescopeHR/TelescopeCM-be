<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::truncate();

        $superAdminRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_SUPER_ADMIN, 'name' => Role::ROLE_SUPER_ADMIN, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_SUPER_ADMIN, 'name' => Role::ROLE_SUPER_ADMIN, 'type' => Role::TYPE_SYSTEM]
        );

        $companyAdminRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_COMPANY_ADMIN, 'name' => Role::ROLE_COMPANY_ADMIN, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_COMPANY_ADMIN, 'name' => Role::ROLE_COMPANY_ADMIN, 'type' => Role::TYPE_SYSTEM]
        );

        $employeeCareWorkerRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_CARE_WORKER, 'name' => Role::ROLE_CARE_WORKER, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_CARE_WORKER, 'name' => Role::ROLE_CARE_WORKER, 'type' => Role::TYPE_SYSTEM]
        );

        $patientRole = Role::updateOrCreate(
            ['id' => Role::ROLE_ID_PATIENT, 'name' => Role::ROLE_PATIENT, 'type' => Role::TYPE_SYSTEM],
            ['id' => Role::ROLE_ID_PATIENT, 'name' => Role::ROLE_PATIENT, 'type' => Role::TYPE_SYSTEM]
        );

        /*   $employeeRole = Role::updateOrCreate(
               ['name' => __('Company Employee'), 'type' => Role::TYPE_SYSTEM],
               ['name' => __('Company Employee'), 'type' => Role::TYPE_SYSTEM]
           );

           $friendRole = Role::updateOrCreate(
               ['name' => __('Employee Friend or Family'), 'type' => Role::TYPE_SYSTEM],
               ['name' => __('Employee Friend or Family'), 'type' => Role::TYPE_SYSTEM]
           );

        */


        $superAdminUser = User::find(1);

        $superAdminUser->addedRoles()->saveMany([$superAdminRole]);

        if (!$superAdminRole->users->contains($superAdminUser->id)) {
            $superAdminRole->users()->attach($superAdminUser);
        }

        $companyAdminUser = User::find(3);

        $companyAdminUser->addedRoles()->saveMany([$companyAdminRole]);

        if (!$companyAdminRole->users->contains($companyAdminUser->id)) {
            $companyAdminRole->users()->attach($companyAdminUser);
        }

        $companyAdminUser2 = User::find(4);

        $companyAdminUser2->addedRoles()->saveMany([$companyAdminRole]);

        if (!$companyAdminRole->users->contains($companyAdminUser2->id)) {
            $companyAdminRole->users()->attach($companyAdminUser2);
        }

        $careWorkerUser = User::find(5);
        $careWorkerUser->addedRoles()->saveMany([$employeeCareWorkerRole]);

        if (!$employeeCareWorkerRole->users->contains($careWorkerUser->id)) {
            $employeeCareWorkerRole->users()->attach($careWorkerUser);
        }

        $clientUser = User::find(6);
        $clientUser->addedRoles()->saveMany([$patientRole]);

        if (!$patientRole->users->contains($clientUser->id)) {
            $patientRole->users()->attach($clientUser);
        }
    }
}
