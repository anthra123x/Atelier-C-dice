<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAgentService
{
    protected string $apiKey;

    protected string $model;

    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('services.openrouter.api_key', env('OPENROUTER_API_KEY', ''));
        $this->model = (string) config('services.openrouter.model', env('OPENROUTER_MODEL', 'liquid/lfm-2.5-2.6b:free'));
        $this->baseUrl = (string) config('services.openrouter.base_url', env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'));
    }

    /**
     * Send conversational prompt to the Narrative Architect AI Agent.
     */
    public function chat(string $prompt, ?string $context = null): string
    {
        $systemPrompt = 'Eres el Arquitecto Narrativo de Códice (Códice AI), un agente de inteligencia artificial especializado en worldbuilding, creación de tramas, dossiers de personajes y cartografía espacial ciberpunk y fantástica. Responde en español con tono evocador, analítico, profesional y conciso.';

        if ($context) {
            $systemPrompt .= "\nContexto actual del universo:\n".$context;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url', 'http://localhost:8000'),
                'X-Title' => 'Estudio Codice Atelier',
            ])->timeout(30)->post($this->baseUrl.'/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 800,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? null;
                if (! empty($content)) {
                    return trim($content);
                }
                // Check if reasoning exists as fallback
                $reasoning = $data['choices'][0]['message']['reasoning'] ?? null;
                if (! empty($reasoning)) {
                    return trim($reasoning);
                }
            }

            Log::warning('OpenRouter API Response Error: '.$response->body());

            return 'Lo siento, no pude conectar con el núcleo neuronal de Códice en este momento. Inténtalo de nuevo.';
        } catch (\Throwable $e) {
            Log::error('OpenRouter Exception: '.$e->getMessage());

            return 'Error al comunicarse con el servicio de IA: '.$e->getMessage();
        }
    }

    /**
     * Generate a structured element for the canvas or compendium.
     *
     * @return array<string, mixed>
     */
    public function generateElement(string $type, string $prompt, ?string $context = null): array
    {
        $instruction = match ($type) {
            'character' => 'Genera un personaje en formato JSON estricto con las claves: "name", "role", "quote", "traits" (array de 3 strings), "bio".',
            'location' => 'Genera una locación en formato JSON estricto con las claves: "name", "sector", "threat_level" (entero 1 a 5), "intel", "description".',
            default => 'Genera una nota de lore en formato JSON estricto con las claves: "title", "content", "tags" (array de 3 strings).'
        };

        $fullPrompt = "{$instruction}\nInstrucción del usuario: {$prompt}\nIMPORTANTE: Responde ÚNICAMENTE con el bloque JSON, sin texto explicativo adicional.";

        $rawResponse = $this->chat($fullPrompt, $context);

        // Extract JSON using regex if surrounded by markdown code blocks
        if (preg_match('/\{[\s\S]*\}/', $rawResponse, $matches)) {
            $decoded = json_decode($matches[0], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        // Fallback structure if model returns plain text
        return [
            'title' => 'Sugerencia de Códice AI: '.substr($prompt, 0, 40),
            'content' => $rawResponse,
            'tags' => ['CódiceAI', 'Generado'],
        ];
    }
}
