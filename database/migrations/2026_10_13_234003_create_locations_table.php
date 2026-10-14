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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universe_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('sector');
            $table->string('icon')->default('location_on');
            $table->string('color')->default('#4F46E5');
            $table->double('map_x')->default(0);
            $table->double('map_y')->default(0);
            $table->string('status')->default('Activo');
            $table->text('description');
            $table->text('intel')->nullable();
            $table->unsignedSmallInteger('threat_level')->default(1);
            $table->jsonb('key_contacts')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();

            $table->index(['universe_id', 'sector']);
            $table->index(['map_x', 'map_y']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
