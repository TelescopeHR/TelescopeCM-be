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
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('manual_client_id')->nullable();
            $table->tinyInteger('client_status')->default(1);
            $table->string('social_security')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_profiles');
    }
};
