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
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedTinyInteger('value_type')->default(0);
            $table->string('title', 100);
            $table->string('key', 100)->unique();
            $table->string('value');
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
        Schema::dropIfExists('settings', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
    }
};
