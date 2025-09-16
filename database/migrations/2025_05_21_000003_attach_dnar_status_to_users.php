<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\CustomStatus;
use App\Models\User;

class AttachDnarStatusToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the DNAR custom status ID
        $dnarStatus = DB::table('custom_statuses')
            ->where('name', 'DNAR')
            ->first();

        if (!$dnarStatus) {
            // If DNAR status doesn't exist, log an error and return
            echo "DNAR status not found in custom_statuses table. Migration aborted.\n";
            return;
        }

        // Get users with the specified roles
        $patientRoleId = DB::table('roles')->where('name', Role::ROLE_PATIENT)->value('id');
        $employeeRoleId = DB::table('roles')->where('name', Role::ROLE_ID_CARE_WORKER)->value('id');

        if (!$patientRoleId && !$employeeRoleId) {
            echo "Required roles not found. Migration aborted.\n";
            return;
        }

        // Get users with patient role
        $userIds = DB::table('role_user')
            ->whereIn('role_id', array_filter([$patientRoleId, $employeeRoleId]))
            ->pluck('user_id')
            ->unique()
            ->toArray();

        if (empty($userIds)) {
            echo "No users found with the specified roles. Migration aborted.\n";
            return;
        }

        // Prepare data for insertion
        $now = now();
        $insertData = [];

        foreach ($userIds as $userId) {
            // Check if the user already has the DNAR status
            $exists = DB::table('user_custom_statuses')
                ->where('user_id', $userId)
                ->where('custom_status_id', $dnarStatus->id)
                ->exists();

            if (!$exists) {
                $insertData[] = [
                    'user_id' => $userId,
                    'custom_status_id' => $dnarStatus->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert the data in chunks to avoid memory issues with large datasets
        if (!empty($insertData)) {
            foreach (array_chunk($insertData, 100) as $chunk) {
                DB::table('user_custom_statuses')->insert($chunk);
            }
            echo count($insertData) . " users have been assigned the DNAR status.\n";
        } else {
            echo "All eligible users already have the DNAR status. No changes made.\n";
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Get the DNAR custom status ID
        $dnarStatus = DB::table('custom_statuses')
            ->where('name', 'DNAR')
            ->first();

        if (!$dnarStatus) {
            return;
        }

        // Get users with the specified roles
        $patientRoleId = DB::table('roles')->where('name', Role::ROLE_PATIENT)->value('id');
        $employeeRoleId = DB::table('roles')->where('name', Role::ROLE_CARE_WORKER)->value('id');

        if (!$patientRoleId && !$employeeRoleId) {
            return;
        }

        // Get users with patient or employee role
        $userIds = DB::table('role_user')
            ->whereIn('role_id', array_filter([$patientRoleId, $employeeRoleId]))
            ->pluck('user_id')
            ->unique()
            ->toArray();

        if (empty($userIds)) {
            return;
        }

        // Remove DNAR status from these users
        $deleted = DB::table('user_custom_statuses')
            ->where('custom_status_id', $dnarStatus->id)
            ->whereIn('user_id', $userIds)
            ->delete();

        echo $deleted . " DNAR status assignments have been removed.\n";
    }
}
