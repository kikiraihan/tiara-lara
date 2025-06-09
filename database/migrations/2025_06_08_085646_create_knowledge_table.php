<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE EXTENSION IF NOT EXISTS vector");
        Schema::create('knowledge', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            // Aktifkan ekstensi pgvector jika belum ada
            $table->id();
            $table->text('content');
            $table->integer('page')->nullable();
            $table->timestamps();
            
            $table->foreignId('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->string('immutable_document_title')->nullable();
            $table->string('immutable_document_category')->nullable();
        });
        // Tambahkan kolom embedding dengan tipe vector(768)
        // Kolom 'embedding' akan ditambahkan lewat raw SQL
        DB::statement("ALTER TABLE knowledge ADD COLUMN embedding vector(768)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge');
    }
};
