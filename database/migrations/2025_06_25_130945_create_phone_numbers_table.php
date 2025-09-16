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
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('phone_type')->default(1);
            $table->string('phone');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_numbers');
    }
};
