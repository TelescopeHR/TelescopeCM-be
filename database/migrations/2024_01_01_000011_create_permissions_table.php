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
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id');
            $table->string('action', 100)->nullable()->default(null);
            $table->string('title', 100)->nullable()->default(null);
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('CASCADE');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions', function (Blueprint $table) {
            $table->dropForeign(['unit_id', 'created_by']);
        });
    }
};
