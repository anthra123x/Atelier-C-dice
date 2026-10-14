<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\CanvasNode;
use App\Models\Universe;
use Tests\TestCase;

class CanvasApiTest extends TestCase
{
    public function test_can_fetch_board_with_graph(): void
    {
        $board = Board::query()->first();
        if (! $board) {
            $universe = Universe::query()->create([
                'title' => 'Test Universe',
                'slug' => 'test-universe',
            ]);
            $board = Board::query()->create([
                'universe_id' => $universe->id,
                'title' => 'Test Board',
                'slug' => 'test-board',
            ]);
        }

        $response = $this->getJson("/api/v1/boards/{$board->id}");

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'nodes',
                    'connections',
                ],
            ]);
    }

    public function test_can_update_node_position(): void
    {
        $node = CanvasNode::query()->first();
        if (! $node) {
            $board = Board::query()->firstOrFail();
            $node = CanvasNode::query()->create([
                'board_id' => $board->id,
                'type' => 'note',
                'title' => 'Sample Note',
                'pos_x' => 100,
                'pos_y' => 200,
            ]);
        }

        $response = $this->patchJson("/api/v1/nodes/{$node->id}/position", [
            'pos_x' => 450.5,
            'pos_y' => 620.5,
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.pos_x', 450.5)
            ->assertJsonPath('data.pos_y', 620.5);

        $this->assertDatabaseHas('canvas_nodes', [
            'id' => $node->id,
            'pos_x' => 450.5,
            'pos_y' => 620.5,
        ]);
    }

    public function test_can_create_and_delete_node(): void
    {
        $board = Board::query()->firstOrFail();

        $createResponse = $this->postJson("/api/v1/boards/{$board->id}/nodes", [
            'type' => 'note',
            'title' => 'Nota Rápida de Investigación',
            'pos_x' => 300,
            'pos_y' => 150,
            'width' => 320,
            'data' => ['content' => 'Revisar cámara de seguridad del muelle.'],
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.title', 'Nota Rápida de Investigación');

        $nodeId = $createResponse->json('data.id');

        $deleteResponse = $this->deleteJson("/api/v1/nodes/{$nodeId}");
        $deleteResponse->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertDatabaseMissing('canvas_nodes', [
            'id' => $nodeId,
        ]);
    }
}
