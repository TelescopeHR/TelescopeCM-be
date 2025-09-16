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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'emergency_name', 'emergency_phone', 'emergency_relation')) {
                $table->string('emergency_phone')->nullable()->after('email');
                $table->string('emergency_relation')->nullable()->after('email');
                $table->string('emergency_name')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'emergency_name', 'emergency_phone', 'emergency_relation')) {
                $table->dropColumn('emergency_phone');
                $table->dropColumn('emergency_relation');
                $table->dropColumn('emergency_name');
            }
        });
    }
};
