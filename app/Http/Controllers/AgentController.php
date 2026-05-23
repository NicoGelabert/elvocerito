<?php

namespace App\Http\Controllers;

use App\Services\AgentService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function __construct(private AgentService $agentService) {}

    public function responder(Request $request)
    {
        $request->validate([
            'pregunta' => 'required|string|max:500',
            'historial' => 'array',
        ]);

        $resultado = $this->agentService->responder(
            pregunta:  $request->pregunta,
            historial: $request->historial ?? [],
        );

        return response()->json($resultado);
    }
}