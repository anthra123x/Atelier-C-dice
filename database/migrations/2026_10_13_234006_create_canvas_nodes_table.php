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
        Schema::create('canvas_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // character, location, note, audio, board, media
            $table->string('title');
            $table->double('pos_x')->default(0);
            $table->double('pos_y')->default(0);
            $table->unsignedInteger('width')->default(360);
            $table->unsignedInteger('height')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->jsonb('data')->nullable();
            $table->timestamps();

            $table->index(['board_id', 'type']);
            $table->index(['pos_x', 'pos_y']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvas_nodes');
    }
};
