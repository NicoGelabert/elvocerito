<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class AgentService
{
    private string $apiKey;
    private string $model = 'llama-3.3-70b-versatile';
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

        try {
            for ($i = 0; $i < $this->maxIteraciones; $i++) {
                $respuesta = $this->llamarGroq($mensajes);
                $mensaje   = $respuesta['choices'][0]['message'];
                $mensajes[] = $mensaje;

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

                        $mensajes[] = [
                            'role'         => 'tool',
                            'tool_call_id' => $toolCall['id'],
                            'content'      => json_encode($resultado),
                        ];
                    }
                } else {
                    return [
                        'respuesta' => $mensaje['content'],
                        'pasos'     => $pasos,
                        'historial' => $mensajes,
                    ];
                }
            }
        } catch (\Exception $e) {
            return [
                'respuesta' => 'Hubo un error al procesar tu consulta. Intentá de nuevo.',
                'pasos'     => $pasos,
                'historial' => $historial,
                'error'     => $e->getMessage(),
            ];
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
                'model'       => $this->model,
                'messages'    => array_merge([['role' => 'system', 'content' => $this->systemPrompt()]], $mensajes),
                'tools'       => $this->definicionHerramientas(),
                'tool_choice' => 'auto',
            ]);

        $data = $response->json();

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
        Cuando presentes resultados, mostrá siempre para cada anunciante:
        - Nombre con su enlace seguido de la calificación si existe, en la misma línea. Ej: [Nombre](url) ⭐4,5 (3 reseñas)
        - Descripción breve sin usar la palabra "Descripción:"
        - El valor del campo "contacto" si existe. Si es null, no menciones contacto.
        Usá formato markdown para los enlaces: [Nombre](url)
        Si no encontrás nada, sugerí buscar con otros términos.
        PROMPT;
    }

    // ─── DEFINICIÓN DE HERRAMIENTAS ───────────────────────────────────────
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

    // ─── HELPER: CONTACTO ─────────────────────────────────────────────────
    private function obtenerContacto($contactos): ?string
    {
        $prioridad = ['whatsapp', 'móvil', 'fijo', 'email'];

        foreach ($prioridad as $tipo) {
            $contacto = $contactos->firstWhere('type', $tipo);
            if ($contacto) {
                return "{$contacto->type}: {$contacto->info}";
            }
        }

        return null;
    }

    // ─── TOOL: BUSCAR ANUNCIANTES ─────────────────────────────────────────
    private function buscarAnunciantes(string $texto, ?string $categoria, int $limite): array
    {
        $query = Product::query()
            ->where('published', true)
            ->with(['categories', 'contacts', 'addresses', 'tags', 'listitems'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            // Primero los que tienen reviews, después los que no
            ->orderByRaw('reviews_count > 0 DESC')
            ->orderByDesc('reviews_count')
            ->where(function ($q) use ($texto) {
                $q->where('title', 'like', "%{$texto}%")
                  ->orWhere('short_description', 'like', "%{$texto}%")
                  ->orWhereHas('tags', fn($t) => $t->where('name', 'like', "%{$texto}%"))
                  ->orWhereHas('categories', fn($c) => $c->where('name', 'like', "%{$texto}%"))
                  ->orWhereHas('listitems', fn($l) => $l->where('item', 'like', "%{$texto}%"));;
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
                'contacto'    => $this->obtenerContacto($p->contacts),
                'direccion'   => $p->addresses->first()?->address,
                'url'         => $p->categories->first()
                    ? url("/{$p->categories->first()->slug}/{$p->slug}")
                    : url("/anunciantes/{$p->slug}"),
                'reviews'     => $p->reviews_count > 0
                    ? '⭐' . number_format($p->reviews_avg_rating, 1) . ' (' . $p->reviews_count . ' reseñas)'
                    : null,
            ]),
        ];
    }
}