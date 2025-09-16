<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->boolean('gender')->nullable()->default(null);
            $table->date('birthday')->nullable()->default(null);

            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();

            $table->unsignedBigInteger('company_id')->nullable()->default(null);
            $table->unsignedBigInteger('country_id')->nullable()->default(null);

            $table->string('zip', 10)->nullable()->default(null);
            $table->string('city', 100)->nullable()->default(null);
            $table->string('state', 100)->nullable();
            $table->string('address', 100)->nullable()->default(null);
            $table->text('instructions')->nullable();

            $table->string('phone', 50)->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);

            $table->timestamp('last_login_at')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();

            $table->tinyInteger('status')->default(0);
            $table->foreignId('created_by')->nullable()->nullOnDelete();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('SET NULL');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
