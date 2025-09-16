<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('mood_types')->insert([
            ['slug' => 'happy',     'title' => 'Happy',     'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'neutral',   'title' => 'Neutral',   'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'tired',     'title' => 'Tired',     'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'depressed', 'title' => 'Depressed', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('mood_types')
            ->whereIn('slug', ['happy', 'neutral', 'tired', 'depressed'])
            ->delete();
    }
};
