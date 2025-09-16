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
        // Check if visit with ID 1 exists
        $visitExists = DB::table('visits')->where('id', 1)->exists();

        if ($visitExists) {
            // Check if morning visit type exists
            $morningVisitType = DB::table('visit_types')
                ->where('slug', 'morning-visit')
                ->first();

            if ($morningVisitType) {
                // Add morning visit type to visit ID 1
                DB::table('visit_visit_types')->insert([
                    'visit_id' => 1,
                    'visit_type_id' => $morningVisitType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the visit type association for visit ID 1
        DB::table('visit_visit_types')
            ->where('visit_id', 1)
            ->delete();
    }
};
