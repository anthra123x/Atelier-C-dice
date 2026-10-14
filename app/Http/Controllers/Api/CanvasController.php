<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCanvasConnectionRequest;
use App\Http\Requests\StoreCanvasNodeRequest;
use App\Http\Requests\UpdateCanvasNodeRequest;
use App\Http\Requests\UpdateNodePositionRequest;
use App\Http\Resources\BoardResource;
use App\Http\Resources\CanvasConnectionResource;
use App\Http\Resources\CanvasNodeResource;
use App\Models\Board;
use App\Models\CanvasConnection;
use App\Models\CanvasNode;
use App\Services\CanvasService;
use Illuminate\Http\JsonResponse;

class CanvasController extends Controller
{
    public function __construct(
        protected CanvasService $canvasService
    ) {}

    /**
     * Display the board and its canvas graph (nodes and connections).
     */
    public function show(int $boardId): JsonResponse
    {
        $board = $this->canvasService->getBoardWithGraph($boardId);

        return response()->json([
            'status' => 'success',
            'data' => new BoardResource($board),
        ]);
    }

    /**
     * Store a newly created node on the board.
     */
    public function storeNode(StoreCanvasNodeRequest $request, Board $board): JsonResponse
    {
        $node = $this->canvasService->createNode($board, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Nodo creado en el lienzo correctamente.',
            'data' => new CanvasNodeResource($node),
        ], 201);
    }

    /**
     * Update node data.
     */
    public function updateNode(UpdateCanvasNodeRequest $request, CanvasNode $node): JsonResponse
    {
        $updated = $this->canvasService->updateNode($node, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Nodo actualizado correctamente.',
            'data' => new CanvasNodeResource($updated),
        ]);
    }

    /**
     * Persist dragged node coordinates.
     */
    public function updatePosition(UpdateNodePositionRequest $request, CanvasNode $node): JsonResponse
    {
        $validated = $request->validated();
        $updated = $this->canvasService->updateNodePosition(
            $node,
            (float) $validated['pos_x'],
            (float) $validated['pos_y']
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Coordenadas del nodo guardadas.',
            'data' => new CanvasNodeResource($updated),
        ]);
    }

    /**
     * Remove the node from the canvas.
     */
    public function destroyNode(CanvasNode $node): JsonResponse
    {
        $this->canvasService->deleteNode($node);

        return response()->json([
            'status' => 'success',
            'message' => 'Nodo eliminado del lienzo.',
        ]);
    }

    /**
     * Create a connection vector between two nodes.
     */
    public function storeConnection(StoreCanvasConnectionRequest $request, Board $board): JsonResponse
    {
        $connection = $this->canvasService->createConnection($board, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Conexión vectorial establecida.',
            'data' => new CanvasConnectionResource($connection),
        ], 201);
    }

    /**
     * Delete a connection vector.
     */
    public function destroyConnection(CanvasConnection $connection): JsonResponse
    {
        $this->canvasService->deleteConnection($connection);

        return response()->json([
            'status' => 'success',
            'message' => 'Conexión eliminada.',
        ]);
    }
}
