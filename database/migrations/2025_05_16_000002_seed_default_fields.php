<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('fields')->insert([
            [
                'key' => 'shift_notes',
                'name' => 'help_block',
                'title' => 'How you helped the patient?',
                'required' => true,
                'validation_rules' => 'array|exists:help_types,id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'shift_notes',
                'name' => 'mood_tracking',
                'title' => 'Mood Tracking',
                'required' => true,
                'validation_rules' => 'array|exists:mood_types,id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'shift_notes',
                'name' => 'notes',
                'title' => 'Notes',
                'validation_rules' => 'array|array_without_empty_rows|min:1|max_from_settings:max_shift_notes_per_visit',
                'required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('fields')
            ->where('key', 'shift_notes')
            ->whereIn('name', ['help_block', 'mood_tracking', 'notes'])
            ->delete();
    }
};
