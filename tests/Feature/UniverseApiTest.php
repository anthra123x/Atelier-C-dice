<?php

namespace Tests\Feature;

use App\Models\Universe;
use Tests\TestCase;

class UniverseApiTest extends TestCase
{
    public function test_can_fetch_universe_overview(): void
    {
        $universe = Universe::query()->firstOrFail();

        $response = $this->getJson("/api/v1/universes/{$universe->slug}");

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.slug', $universe->slug)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'tagline',
                    'settings',
                    'boards',
                    'collaborators',
                ],
            ]);
    }

    public function test_can_list_and_create_characters(): void
    {
        $universe = Universe::query()->firstOrFail();

        $listResponse = $this->getJson("/api/v1/universes/{$universe->id}/characters");
        $listResponse->assertOk()
            ->assertJsonPath('status', 'success');

        $createResponse = $this->postJson("/api/v1/universes/{$universe->id}/characters", [
            'name' => 'Soran Kurogane',
            'code' => 'NEO-8801',
            'role' => 'Corredor de Información & Hacker',
            'status' => 'Neutral',
            'quote' => 'Todo tiene un precio en megabytes.',
            'traits' => ['Criptografía', 'Redes Oscuras'],
            'palette' => ['#000000', '#F59E0B', '#64748B'],
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.name', 'Soran Kurogane');
    }

    public function test_can_list_and_create_locations(): void
    {
        $universe = Universe::query()->firstOrFail();

        $listResponse = $this->getJson("/api/v1/universes/{$universe->id}/locations");
        $listResponse->assertOk()
            ->assertJsonPath('status', 'success');

        $createResponse = $this->postJson("/api/v1/universes/{$universe->id}/locations", [
            'name' => 'Refugio Subterráneo 09',
            'code' => '#09',
            'sector' => 'Sector 00 · Terreno Inundado',
            'map_x' => 180,
            'map_y' => 690,
            'status' => 'Oculto',
            'threat_level' => 2,
            'description' => 'Túneles de servicio olvidados bajo la cota del mar.',
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.name', 'Refugio Subterráneo 09');
    }
}
