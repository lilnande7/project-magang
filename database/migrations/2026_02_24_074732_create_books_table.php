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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->year('year')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('Indonesia');
            $table->text('description')->nullable();
            $table->string('location')->nullable(); // Lokasi di rak
            $table->enum('status', ['available', 'borrowed', 'maintenance', 'lost'])->default('available');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('subjects')->nullable(); // Subjek/topik buku
            $table->integer('stock')->default(1);
            $table->timestamps();
            
            $table->index(['title', 'author']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
