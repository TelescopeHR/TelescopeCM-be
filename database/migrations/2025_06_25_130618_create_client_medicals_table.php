<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('client_medicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->string('manual_medical_id')->nullable();
            $table->date('admitted_at')->nullable();
            $table->string('living_with')->nullable();
            $table->tinyInteger('able_to_respond')->nullable();
            $table->text('allergies')->nullable();
            $table->tinyInteger('classification')->nullable();
            $table->tinyInteger('condition')->nullable();
            $table->tinyInteger('priority')->nullable();
            $table->tinyInteger('dnr')->nullable();
            $table->text('medical_instructions')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_medicals');
    }
};
