<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarePlanCategory;

class CarePlanCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarePlanCategory::truncate();

        CarePlanCategory::updateOrCreate(['name' => __('Personal Care')]);
        CarePlanCategory::updateOrCreate(['name' => __('Companion Care & Socialization')]);
        CarePlanCategory::updateOrCreate(['name' => __('Household Assistance')]);
        CarePlanCategory::updateOrCreate(['name' => __('Safety & Supervision')]);
        CarePlanCategory::updateOrCreate(['name' => __('Special Medical Needs')]);
    }
}
