<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('help_types')->insert([
            ['slug' => 'medication', 'title' => 'Medication', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'body-map',  'title' => 'Body map',   'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'food',      'title' => 'Food',       'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'drinks',    'title' => 'Drinks',     'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('help_types')
            ->whereIn('slug', ['medication','body-map','food','drinks'])
            ->delete();
    }
};
