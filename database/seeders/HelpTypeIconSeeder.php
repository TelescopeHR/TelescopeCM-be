<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HelpType;

class HelpTypeIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'medication' => 'medication.png',
            'body-map'   => 'body-map.png',
            'food'       => 'food.png',
            'drinks'     => 'drinks.png',
        ];

        foreach ($map as $slug => $file) {
            $help = HelpType::where('slug', $slug)->first();
            if (!$help) {
                $this->command->warn("HelpType {$slug} not found");
                continue;
            }

            // пропустити, якщо іконка вже є
            if ($help->getFirstMedia('icon')) {
                continue;
            }

            $path = storage_path("app/help_type_icons/{$file}");
            if (!file_exists($path)) {
                $this->command->error("Icon file {$file} missing");
                continue;
            }

            $help->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('icon');
        }

    }
}
