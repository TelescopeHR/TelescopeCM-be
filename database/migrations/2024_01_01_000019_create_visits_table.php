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
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id');
            $table->foreignId('schedule_id')->nullable();
            $table->string('type', 50)->nullable();
            $table->foreignId('care_worker_id')->nullable();
            $table->string('pay_rate', 255)->nullable();
            $table->timestamp('date_at')->nullable();
            $table->time('time_in');
            $table->time('time_out');
            $table->time('verified_in')->nullable();
            $table->time('verified_out')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits', function (Blueprint $table) {
            $table->dropForeign(['patient_id', 'care_worker_id', 'schedule_id', 'created_by']);
        });
    }
};
