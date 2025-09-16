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
        Schema::create('user_relatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('relative_id');
            $table->string('relative_name', 100);
            $table->timestamps();

            $table->unique(['user_id', 'relative_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('relative_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relatives', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'relative_id']);
        });
    }
};
