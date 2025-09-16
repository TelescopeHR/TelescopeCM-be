<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setting::truncate();

        $adminUser = User::find(1);

        if (!$adminUser) {
            return;
        }

        // $adminUser->settings()->updateOrCreate(
        //     ['key' => 'admin_email'],
        //     [
        //         'type' => Setting::TYPE_SYSTEM,
        //         'value_type' => Setting::TYPE_EMAIL,
        //         'title' => __('Administrator Email'),
        //         'value' => 'admin@gmail.com',
        //     ]
        // );

        // $adminUser->settings()->updateOrCreate(
        //     ['key' => 'admin_name'],
        //     [
        //         'type' => Setting::TYPE_SYSTEM,
        //         'value_type' => Setting::TYPE_STRING,
        //         'title' => __('Administrator Name'),
        //         'value' => 'Admin Name',
        //     ]
        // );

        // $adminUser->settings()->updateOrCreate(
        //     ['key' => 'show_prescriptions'],
        //     [
        //         'type' => Setting::TYPE_SYSTEM,
        //         'value_type' => Setting::TYPE_EMAIL,
        //         'title' => __('Show Prescriptions'),
        //         'value' => 'show_prescriptions',
        //     ]
        // );

        $adminUser->settings()->updateOrCreate(
            ['key' => 'max_shift_notes_per_visit'],
            [
                'title' => 'Maximum Shift Notes Per Visit',
                'value' => '5',
            ]
        );
    }
}
