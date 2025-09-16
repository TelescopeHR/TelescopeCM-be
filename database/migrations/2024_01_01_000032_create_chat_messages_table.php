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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['chat_id', 'user_id', 'created_by']);
        });
    }
};
