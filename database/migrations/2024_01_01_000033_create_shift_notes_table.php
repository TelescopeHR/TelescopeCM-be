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
        Schema::create('shift_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->timestamp('date_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shift_notes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::dropIfExists('shift_notes');
    }
};
