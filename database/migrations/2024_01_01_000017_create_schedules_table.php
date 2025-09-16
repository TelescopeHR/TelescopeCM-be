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
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('patient_id');
            $table->foreignId('care_plan_id')->nullable();
            $table->foreignId('care_worker_id')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->float('rate')->nullable();
            $table->unsignedTinyInteger('status')->default(0); // 0 - Inactive, 1 - Active
            $table->foreignId('created_by')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules', function (Blueprint $table) {});
    }
};
