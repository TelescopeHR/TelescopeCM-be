<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\ShiftNote;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visits = Visit::limit(10)->get();

        if ($visits->isNotEmpty()) {
            $visits->each(function ($visit) {
                ShiftNote::create([
                    'visit_id' => $visit->id,
                    'user_id' => $visit->client_id,
                    'created_by' => $visit->care_worker_id,
                    'message' => 'employee notes message ' . $visit->id,
                    'date_at' => now()->format('Y-m-d'),
                ]);
            });
        }
    }
}
