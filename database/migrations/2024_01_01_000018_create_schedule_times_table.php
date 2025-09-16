<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('schedule_id');
            $table->unsignedInteger('day_of_week');  // N - 1 (for Monday) through 7 (for Sunday)
            $table->time('time_from');
            $table->time('time_to');
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_times', function (Blueprint $table) {});
    }
};
