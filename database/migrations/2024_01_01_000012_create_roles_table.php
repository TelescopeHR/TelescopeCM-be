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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
    }
};
