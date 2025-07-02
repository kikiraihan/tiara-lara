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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('category',255);
            $table->integer('total_pages')->nullable();
            $table->decimal('file_size',2)->nullable();//in kilobyte
            $table->enum('knowledge_status',['success','pending','failed','not_yet'])->default('not_yet');
            
            $table->boolean('is_private');
            $table->string('file_path',255);
            $table->timestamp('last_proc_at')->nullable()
                ->comment("Last time the doc is processed");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
