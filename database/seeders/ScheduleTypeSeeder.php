<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScheduleType;

class ScheduleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScheduleType::truncate();

        ScheduleType::updateOrCreate(['name' => __('Daily Fixed')]);
        ScheduleType::updateOrCreate(['name' => __('Daily Variable')]);
        ScheduleType::updateOrCreate(['name' => __('No Schedule')]);
        ScheduleType::updateOrCreate(['name' => __('Weekly Variable')]);
    }
}
