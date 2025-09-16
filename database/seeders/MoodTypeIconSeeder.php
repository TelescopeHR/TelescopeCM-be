<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MoodType;

class MoodTypeIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'happy' => 'happy.png',
            'neutral' => 'neutral.png',
            'tired' => 'tired.png',
            'depressed' => 'depressed.png',
        ];

        foreach ($map as $slug => $file) {
            $mood = MoodType::where('slug', $slug)->first();
            if (!$mood) {
                $this->command->warn("MoodType {$slug} not found");
                continue;
            }

            // Delete the old icon
            $oldMedia = $mood->getFirstMedia('icon');
            if ($oldMedia) {
                $oldMedia->delete();
            }

            $path = storage_path("app/mood_type_icons/{$file}");
            if (!file_exists($path)) {
                $this->command->error("Icon file {$file} missing");
                continue;
            }

            $mood->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('icon');
        }
    }
}
