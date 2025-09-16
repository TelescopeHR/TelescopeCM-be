<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();

        Company::create([
            'name' => __('Telescope Company'),
            'status' => Company::STATUS_ACTIVE,
        ]);

        Company::create([
            'name' => __('Telescope Company 2'),
            'status' => Company::STATUS_ACTIVE,
        ]);
    }
}
