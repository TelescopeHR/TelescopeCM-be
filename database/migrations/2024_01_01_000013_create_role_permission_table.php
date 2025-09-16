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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();

            $table->unique(['role_id', 'permission_id']);

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission', function (Blueprint $table) {
            $table->dropForeign(['role_id', 'permission_id']);
        });
    }
};
