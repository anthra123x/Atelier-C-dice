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
        Schema::create('audio_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universe_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('artist')->default('Unknown');
            $table->string('category')->default('Ambient');
            $table->string('duration')->default('03:45');
            $table->text('audio_url')->nullable();
            $table->jsonb('waveform')->nullable();
            $table->boolean('is_loop')->default(true);
            $table->timestamps();

            $table->index(['universe_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_tracks');
    }
};
