<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class AgentService
{
    private string $apiKey;
    private string $model = 'llama-3.3-70b-versatile'; // gratis en Groq
    private int $maxIteraciones = 5;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

    // ─── PUNTO DE ENTRADA ────────────────────────────────────────────────
    public function responder(string $pregunta, array $historial = []): array
    {
        $mensajes = array_merge($historial, [
            ['role' => 'user', 'content' => $pregunta]
        ]);

        $pasos = [];

        for ($i = 0; $i < $this->maxIteraciones; $i++) {
            $respuesta = $this->llamarGroq($mensajes);
            $mensaje   = $respuesta['choices'][0]['message'];
            $mensajes[] = $mensaje;

            // ¿El modelo quiere usar una herramienta?
            if (!empty($mensaje['tool_calls'])) {
                foreach ($mensaje['tool_calls'] as $toolCall) {
                    $nombre    = $toolCall['function']['name'];
                    $args      = json_decode($toolCall['function']['arguments'], true);
                    $resultado = $this->ejecutarHerramienta($nombre, $args);

                    $pasos[] = [
                        'herramienta' => $nombre,
                        'args'        => $args,
                        'resultado'   => $resultado,
                    ];

                    // Devolver resultado de la tool al modelo
                    $mensajes[] = [
                        'role'         => 'tool',
                        'tool_call_id' => $toolCall['id'],
                        'content'      => json_encode($resultado),
                    ];
                }
            } else {
                // El modelo terminó → respuesta final
                return [
                    'respuesta' => $mensaje['content'],
                    'pasos'     => $pasos,
                    'historial' => $mensajes,
                ];
            }
        }

        return [
            'respuesta' => 'No pude encontrar una respuesta. Intentá con otra búsqueda.',
            'pasos'     => $pasos,
            'historial' => $mensajes,
        ];
    }

    // ─── LLAMADA A GROQ ───────────────────────────────────────────────────
    private function llamarGroq(array $mensajes): array
    {
        $response = Http::withToken($this->apiKey)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'    => $this->model,
                'messages' => array_merge([['role' => 'system', 'content' => $this->systemPrompt()]], $mensajes),
                'tools'    => $this->definicionHerramientas(),
                'tool_choice' => 'auto',
            ]);

        return $response->json();
        // Si la API devuelve error, lanzarlo con detalle
        if (isset($data['error'])) {
            throw new \Exception('Groq API error: ' . $data['error']['message']);
        }

        if (!isset($data['choices'])) {
            throw new \Exception('Respuesta inesperada de Groq: ' . json_encode($data));
        }

        return $data;
    }

    // ─── SYSTEM PROMPT ────────────────────────────────────────────────────
    private function systemPrompt(): string
    {
        return <<<PROMPT
        Sos un asistente de búsqueda para un directorio de negocios locales del sur del Gran Buenos Aires.
        Tu trabajo es ayudar a los usuarios a encontrar anunciantes según lo que necesiten.
        Cuando el usuario pida algo, usá la herramienta buscar_anunciantes para consultar la base de datos.
        Respondé siempre en español, de forma amigable y concisa.
        Si encontrás resultados, presentalos de forma clara con nombre, descripción y cómo contactarlos.
        Si no encontrás nada, sugerí buscar con otros términos.
        PROMPT;
    }

    // ─── DEFINICIÓN DE HERRAMIENTAS (formato OpenAI) ──────────────────────
    private function definicionHerramientas(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'buscar_anunciantes',
                    'description' => 'Busca anunciantes en la base de datos del directorio según categoría, tags o texto libre. Usá esta herramienta siempre que el usuario pida un servicio o negocio.',
                    'parameters'  => [
                        'type'       => 'object',
                        'properties' => [
                            'texto' => [
                                'type'        => 'string',
                                'description' => 'Término de búsqueda libre, ej: "electricista", "pizzería", "médico clínico"',
                            ],
                            'categoria' => [
                                'type'        => 'string',
                                'description' => 'Nombre de categoría a filtrar, ej: "Salud", "Gastronomía"',
                            ],
                            'limite' => [
                                'type'        => 'integer',
                                'description' => 'Cantidad máxima de resultados. Por defecto 5.',
                            ],
                        ],
                        'required' => ['texto'],
                    ],
                ],
            ],
        ];
    }

    // ─── EJECUTOR DE HERRAMIENTAS ─────────────────────────────────────────
    private function ejecutarHerramienta(string $nombre, array $args): mixed
    {
        return match($nombre) {
            'buscar_anunciantes' => $this->buscarAnunciantes(
                texto:     $args['texto'] ?? '',
                categoria: $args['categoria'] ?? null,
                limite:    $args['limite'] ?? 5,
            ),
            default => ['error' => "Herramienta '$nombre' no existe"],
        };
    }

    // ─── TOOL: BUSCAR ANUNCIANTES ─────────────────────────────────────────
    private function buscarAnunciantes(string $texto, ?string $categoria, int $limite): array
    {
        $query = Product::query()
            ->where('published', true)
            ->with(['categories', 'contacts', 'addresses', 'tags'])
            ->where(function ($q) use ($texto) {
                $q->where('title', 'like', "%{$texto}%")
                  ->orWhere('short_description', 'like', "%{$texto}%")
                  ->orWhereHas('tags', fn($t) => $t->where('name', 'like', "%{$texto}%"))
                  ->orWhereHas('categories', fn($c) => $c->where('name', 'like', "%{$texto}%"));
            });

        if ($categoria) {
            $query->whereHas('categories', fn($c) =>
                $c->where('name', 'like', "%{$categoria}%")
            );
        }

        $products = $query->limit($limite)->get();

        if ($products->isEmpty()) {
            return ['encontrados' => 0, 'mensaje' => 'No se encontraron anunciantes para esa búsqueda.'];
        }

        return [
            'encontrados' => $products->count(),
            'anunciantes' => $products->map(fn($p) => [
                'nombre'      => $p->title,
                'descripcion' => $p->short_description,
                'categorias'  => $p->categories->pluck('name'),
                'tags'        => $p->tags->pluck('name'),
                'contactos'   => $p->contacts->map(fn($c) => [
                    'tipo'  => $c->type,
                    'valor' => $c->value,
                ]),
                'direccion'   => $p->addresses->first()?->address,
                'url'         => url("/anunciantes/{$p->slug}"),
            ]),
        ];
    }
}