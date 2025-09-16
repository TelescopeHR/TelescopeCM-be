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
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('icon_class', 100)->nullable()->default(null);
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('sorting')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('unit_categories')->onDelete('SET NULL');
            $table->foreign('parent_id')->references('id')->on('units')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units', function (Blueprint $table) {
            $table->dropForeign(['parent_id', 'category_id']);
        });
    }
};
