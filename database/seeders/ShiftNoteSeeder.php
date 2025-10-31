<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\ShiftNote;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shift_notes')->truncate();
        
        $visits = Visit::all();

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
