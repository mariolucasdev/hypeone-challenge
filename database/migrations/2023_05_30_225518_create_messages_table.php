<?php

use App\Models\Chat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')
                ->constrained(
                    table: 'chats',
                    indexName: 'messages_chat_id_foreign'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->longText('content');
            $table->string('username');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages', function (Blueprint $table) {
            $table->dropForeign('messages_chat_id_foreign');
        });
    }
};
