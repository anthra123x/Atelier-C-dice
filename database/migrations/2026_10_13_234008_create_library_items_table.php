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
        Schema::create('library_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universe_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category')->default('Lore'); // Lore, Manuscrito, Facciones, etc.
            $table->string('author')->nullable();
            $table->text('content');
            $table->jsonb('tags')->nullable();
            $table->text('file_url')->nullable();
            $table->string('file_type')->default('document');
            $table->timestamps();

            $table->index(['universe_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_items');
    }
};
