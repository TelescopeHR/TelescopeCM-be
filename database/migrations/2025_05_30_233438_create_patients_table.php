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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->boolean('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('status', 20)->default('active');
            $table->string('social_security_number', 50)->nullable();

            $table->string('address', 500)->nullable();
            $table->string('zip', 10)->nullable()->default(null);
            $table->string('city', 100)->nullable()->default(null);
            $table->string('state', 50)->nullable()->default(null);
            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->longText('instructions')->nullable();
           
            $table->string('phone_number', 20)->nullable();
            $table->string('phone_number_type', 20)->nullable();

            $table->string('client_id', 50)->nullable();
            $table->string('member_id', 50)->nullable();
            $table->boolean('admitted')->nullable();
            $table->string('living_with', 500)->nullable();
            $table->boolean('able_to_respond')->default(false);
            $table->longText('allergies')->nullable();
            $table->string('classification', 500)->nullable();
            $table->string('condition', 500)->nullable();
            $table->string('priority', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
