<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->timestamps();
        });

        // Insert initial visit types
        DB::table('visit_types')->insert([
            [
                'slug' => 'morning-visit',
                'title' => 'Morning Visit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'evening-visit',
                'title' => 'Evening Visit',
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
        Schema::dropIfExists('visit_types');
    }
};
