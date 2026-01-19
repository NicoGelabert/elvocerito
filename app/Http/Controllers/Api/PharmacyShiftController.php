<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\PharmacyShift;
use App\Models\Api\Pharmacy;
use App\Http\Requests\PharmacyShiftRequest;
use App\Http\Resources\PharmacyShiftResource;
use Carbon\Carbon;

class PharmacyShiftController extends Controller
{
    public function index()
    {
        $shifts = PharmacyShift::with('pharmacy.product')->get();

        $events = $shifts->map(function ($shift) {
            $pharmacy = $shift->pharmacy;
            $product  = $pharmacy->product ?? null;

            return [
                'id' => $shift->id,
                'title' => $product
                    ? $product->title
                    : ($pharmacy ? "Farmacia #{$pharmacy->id}" : "Farmacia"),
                'start' => $shift->shift_date->format('Y-m-d') . 'T' . $shift->start_time,
                'end'   => $shift->shift_date->format('Y-m-d') . 'T' . $shift->end_time,
                'extendedProps' => [
                    'pharmacy_id' => $shift->pharmacy_id,
                ],
            ];
        });

        return response()->json($events);
    }


    public function store(PharmacyShiftRequest $request)
    {
        $data = $request->validated();
        $userId = $request->user()->id;

        $createdShifts = [];

        foreach ($data['shifts'] as $shiftData) {

            $exists = PharmacyShift::where([
                'shift_date'  => $data['shift_date'],
                'pharmacy_id' => $shiftData['pharmacy_id'],
                'start_time'  => $shiftData['start_time'],
                'end_time'    => $shiftData['end_time'],
            ])->exists();

            if ($exists) {
                continue;
            }

            $shift = PharmacyShift::create([
                'shift_date'  => $data['shift_date'],
                'pharmacy_id' => $shiftData['pharmacy_id'],
                'start_time'  => $shiftData['start_time'],
                'end_time'    => $shiftData['end_time'],
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ]);

            $createdShifts[] = $shift;
        }

        return PharmacyShiftResource::collection($createdShifts);
    }

    public function update(Request $request, $id)
    {
        $shift = PharmacyShift::findOrFail($id);

        $shift->update($request->only(['pharmacy_id','start_time','end_time']));

        return new PharmacyShiftResource($shift);
    }


    public function destroy($id)
    {
        // Buscar el turno por ID
        $shift = PharmacyShift::findOrFail($id);

        // Eliminar
        $shift->delete();

        // Retornar respuesta 204 (sin contenido)
        return response()->noContent();
    }

    public function destroyByDate($date)
    {
        PharmacyShift::where('shift_date', $date)->delete();

        return response()->noContent();
    }
}
