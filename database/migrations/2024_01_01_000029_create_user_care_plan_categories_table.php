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
        Schema::create('user_care_plan_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');
            $table->unsignedBigInteger('item_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_care_plan_categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
