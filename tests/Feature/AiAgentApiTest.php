<?php

namespace Tests\Feature;

use App\Models\Board;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiAgentApiTest extends TestCase
{
    public function test_ai_chat_endpoint_returns_creative_response(): void
    {
        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Las sombras de Neo-Kyoto ocultan más que secretos; guardan la memoria de los caídos.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('api.v1.ai.chat'), [
            'prompt' => 'Cuéntame sobre las facciones rebeldes en el Sector 04.',
        ]);

        $response->assertOk()
            ->assertJson([
                'status' => 'success',
                'reply' => 'Las sombras de Neo-Kyoto ocultan más que secretos; guardan la memoria de los caídos.',
            ]);
    }

    public function test_ai_generate_node_creates_and_attaches_element_to_board(): void
    {
        $board = Board::query()->firstOrFail();

        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'name' => 'Kaelen Vance (Rival)',
                                'role' => 'Mercenario Ex-Covenant',
                                'quote' => 'El código no perdona traiciones.',
                                'traits' => ['Implantes ilegales', 'Netrunner táctico', 'Cicatriz bio-mecánica'],
                                'bio' => 'Antiguo aliado que ahora opera bajo las sombras del Sector 04.',
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('api.v1.ai.generate', $board), [
            'prompt' => 'Genera un rival peligroso para Kaelen Cross con implantes cibernéticos.',
            'type' => 'character',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.title', 'Kaelen Vance (Rival)')
            ->assertJsonPath('data.type', 'character');

        $this->assertDatabaseHas('canvas_nodes', [
            'board_id' => $board->id,
            'title' => 'Kaelen Vance (Rival)',
            'type' => 'character',
        ]);
    }

    public function test_ai_generate_location_node(): void
    {
        $board = Board::query()->firstOrFail();

        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'name' => 'Búnker 07 Clandestino',
                                'sector' => 'Sector 04',
                                'threat_level' => 4,
                                'intel' => 'Refugio fortificado donde se trafican núcleos de memoria borrados.',
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('api.v1.ai.generate', $board), [
            'prompt' => 'Genera un búnker secreto en el Sector 04 con alto nivel de amenaza.',
            'type' => 'location',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.title', 'Búnker 07 Clandestino')
            ->assertJsonPath('data.type', 'location');
    }
}
