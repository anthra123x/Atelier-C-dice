<?php

namespace App\Services;

use App\Models\Board;
use App\Models\CanvasConnection;
use App\Models\CanvasNode;

class CanvasService
{
    /**
     * Get board with eager loaded graph (nodes, outgoing and incoming connections).
     */
    public function getBoardWithGraph(int $boardId): Board
    {
        return Board::query()
            ->with(['nodes', 'connections.sourceNode', 'connections.targetNode'])
            ->findOrFail($boardId);
    }

    /**
     * Create a new node on the board.
     *
     * @param  array<string, mixed>  $data
     */
    public function createNode(Board $board, array $data): CanvasNode
    {
        return $board->nodes()->create($data);
    }

    /**
     * Update an existing node.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateNode(CanvasNode $node, array $data): CanvasNode
    {
        $node->update($data);

        return $node->fresh();
    }

    /**
     * Update node coordinates (drag & drop persistence).
     */
    public function updateNodePosition(CanvasNode $node, float $posX, float $posY): CanvasNode
    {
        $node->update([
            'pos_x' => $posX,
            'pos_y' => $posY,
        ]);

        return $node;
    }

    /**
     * Delete a canvas node and its cascade connections.
     */
    public function deleteNode(CanvasNode $node): bool
    {
        return (bool) $node->delete();
    }

    /**
     * Create a connection between two nodes on the board.
     *
     * @param  array<string, mixed>  $data
     */
    public function createConnection(Board $board, array $data): CanvasConnection
    {
        return $board->connections()->create($data);
    }

    /**
     * Delete a connection.
     */
    public function deleteConnection(CanvasConnection $connection): bool
    {
        return (bool) $connection->delete();
    }
}
