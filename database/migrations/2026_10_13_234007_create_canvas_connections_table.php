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
        Schema::create('canvas_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->foreignId('source_node_id')->constrained('canvas_nodes')->cascadeOnDelete();
            $table->foreignId('target_node_id')->constrained('canvas_nodes')->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->string('badge_icon')->nullable();
            $table->string('curvature')->default('curved');
            $table->string('color')->default('#4F46E5');
            $table->timestamps();

            $table->index(['board_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvas_connections');
    }
};
