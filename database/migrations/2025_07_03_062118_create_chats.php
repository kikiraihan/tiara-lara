<?php

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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id(); 
            $table->uuid("uuid"); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->timestamps(); 
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('chat_session_id')->constrained('chat_sessions')->onDelete('cascade'); 
            $table->enum('sender_type', ['user', 'llm'])->default("user"); 
            $table->text('content'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::dropIfExists('chat_messages'); 
        Schema::dropIfExists('chat_sessions');
    }
};
