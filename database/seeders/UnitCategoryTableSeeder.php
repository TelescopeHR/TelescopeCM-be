<?php

namespace Database\Seeders;

use App\Models\UnitCategory;
use Illuminate\Database\Seeder;

class UnitCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //UnitCategory::truncate();

        $i = 1;

        UnitCategory::updateOrCreate(['name' => __('Clients')], ['id' => 1, 'sorting' => $i++]);
        UnitCategory::updateOrCreate(['name' => __('Employees')], ['id' => 2, 'sorting' => $i++]);
        UnitCategory::updateOrCreate(['name' => __('Others')], ['id' => 3, 'sorting' => $i++]);

        UnitCategory::updateOrCreate(['name' => 'Mobile API'], [
            'id' => 999,
            'name' => 'Mobile API',
            'visible' => true,
            'sorting' => $i++,
        ]);
    }
}
