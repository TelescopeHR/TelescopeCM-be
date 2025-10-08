<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PopulateUuidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::whereNull('uuid')->get()->each(function ($user) {
            $user->update(['uuid' => Str::uuid()]);
        });

        Company::whereNull('uuid')->get()->each(function ($company) {
            $company->update(['uuid' => Str::uuid()]);
        });
    }
}
