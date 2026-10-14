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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('audio_track_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('role');
            $table->string('status')->nullable();
            $table->text('quote')->nullable();
            $table->text('bio')->nullable();
            $table->text('portrait_url')->nullable();
            $table->jsonb('gallery_urls')->nullable();
            $table->jsonb('traits')->nullable();
            $table->jsonb('palette')->nullable();
            $table->timestamps();

            $table->index(['universe_id', 'name']);
            $table->index(['code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
