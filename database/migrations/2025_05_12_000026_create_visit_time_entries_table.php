<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitTimeEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visit_time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('care_worker_id')->constrained('users')->cascadeOnDelete(); // хто фіксує
            $table->timestamp('started_at');
            $table->timestamp('stopped_at')->nullable();
            $table->unsignedInteger('duration')->nullable(); // секунд
            $table->timestamps();
            $table->unique(['visit_id', 'care_worker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_time_entries');
    }
}
