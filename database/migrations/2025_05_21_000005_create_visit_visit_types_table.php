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
        Schema::create('visit_visit_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->unsignedBigInteger('visit_type_id');
            $table->timestamps();

            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('CASCADE');
            $table->foreign('visit_type_id')->references('id')->on('visit_types')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_visit_types');
    }
};
