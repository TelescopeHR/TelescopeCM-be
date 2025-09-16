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
        Schema::table('user_care_plan_categories', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('user_care_plan_categories', 'user_care_plan_id')) {
                $table->unsignedBigInteger('user_care_plan_id')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_care_plan_categories', function (Blueprint $table) {
            //
            if (Schema::hasColumn('user_care_plan_categories', 'user_care_plan_id')) {
                $table->dropColumn('user_care_plan_id');
            }
        });
    }
};
