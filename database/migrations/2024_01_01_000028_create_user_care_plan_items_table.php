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
        Schema::create('user_care_plan_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->text('notes');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('care_plan_categories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, drop foreign keys if they exist
        Schema::table('user_care_plan_items', function (Blueprint $table) {
         
            $table->dropForeign(['category_id']);
        });

        // Then drop the table
        Schema::dropIfExists('user_care_plan_items');
    }
};
