<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CanvasNodeResource;
use App\Models\Board;
use App\Services\AiAgentService;
use App\Services\CanvasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function __construct(
        protected AiAgentService $aiService,
        protected CanvasService $canvasService
    ) {}

    /**
     * Chat with the Narrative Architect AI Agent.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:1500'],
            'context' => ['nullable', 'string', 'max:2000'],
        ]);

        $reply = $this->aiService->chat($validated['prompt'], $validated['context'] ?? null);

        return response()->json([
            'status' => 'success',
            'reply' => $reply,
        ]);
    }

    /**
     * Ask the AI agent to generate a world element and insert it directly into the active board.
     */
    public function generateNode(Request $request, Board $board): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:1000'],
            'type' => ['nullable', 'string', 'in:note,character,location'],
        ]);

        $type = $validated['type'] ?? 'note';
        $element = $this->aiService->generateElement($type, $validated['prompt']);

        // Format data based on node type
        $title = $element['title'] ?? $element['name'] ?? 'Elemento Códice AI';
        $nodeData = match ($type) {
            'character' => [
                'name' => $element['name'] ?? $title,
                'role' => $element['role'] ?? 'Personaje Generado',
                'quote' => $element['quote'] ?? 'La noche guarda los secretos de la ciudad.',
                'traits' => $element['traits'] ?? ['Generado por IA', 'Ciberpunk'],
                'category' => 'FICHA NARRATIVA',
            ],
            'location' => [
                'name' => $element['name'] ?? $title,
                'sector' => $element['sector'] ?? 'Sector Desconocido',
                'threat' => 'Nivel '.($element['threat_level'] ?? 3),
                'intel' => $element['intel'] ?? 'Informe clasificado generado por IA.',
                'category' => 'LOCACIÓN',
            ],
            default => [
                'body' => $element['content'] ?? 'Contenido generado por IA.',
                'tags' => $element['tags'] ?? ['CódiceAI'],
                'category' => 'NOTA DE CAMPO',
            ]
        };

        // Random offset for position so it appears nicely on the canvas
        $node = $this->canvasService->createNode($board, [
            'type' => $type,
            'title' => $title,
            'pos_x' => rand(200, 700),
            'pos_y' => rand(150, 500),
            'width' => 360,
            'data' => $nodeData,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Elemento creado e insertado en el lienzo por Códice AI.',
            'data' => new CanvasNodeResource($node),
        ], 201);
    }
}
