<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Empleado;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidencias = Incidencia::with(['empleado', 'concepto'])->get();
        return response()->json($incidencias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $incidencias = $request->all();
        $errores = [];
        $guardados = [];
        
        foreach ($incidencias as $key => $incidenciaData) {
            $validator = $this->validarIncidencia($incidenciaData);
            
            if ($validator->fails()) {
                $errores[$key] = $validator->errors();
                continue;
            }
            
            $empleado = Empleado::where('numero_empleado', $incidenciaData['numero_empleado'])->first();
            $concepto = Concepto::where('codigo', $incidenciaData['codigo_concepto'])->first();
            
            if (!$empleado || !$concepto) {
                $errores[$key] = ['mensaje' => 'Empleado o concepto no encontrado'];
                continue;
            }
            
            $incidencia = new Incidencia([
                'empleado_id' => $empleado->id,
                'concepto_id' => $concepto->id,
                'fecha' => $incidenciaData['fecha'],
                'cantidad' => $incidenciaData['cantidad'] ?? null,
                'tipo_incidencia' => $incidenciaData['tipo_incidencia'] ?? null,
                'periodo' => $incidenciaData['periodo'] ?? null,
                'hora_entrada' => $incidenciaData['hora_entrada'] ?? null,
                'hora_salida' => $incidenciaData['hora_salida'] ?? null,
                'observaciones' => $incidenciaData['observaciones'] ?? null,
                'estado' => 'pendiente',
                'last_modified_by' => $request->user()->id ?? 'sistema',
            ]);
            
            $incidencia->save();
            $guardados[] = $incidencia;
        }
        
        return response()->json([
            'guardados' => $guardados,
            'errores' => $errores
        ]);
    }
    
    /**
     * Store multiple incidencias from bulk import.
     */
    public function storeMasivo(Request $request)
    {
        return $this->store($request);
    }
    
    /**
     * Validate an incidencia based on its concepto requirements.
     */
    private function validarIncidencia($data)
    {
        $concepto = Concepto::where('codigo', $data['codigo_concepto'])->first();
        
        $rules = [
            'numero_empleado' => 'required|exists:empleados,numero_empleado',
            'codigo_concepto' => 'required|exists:conceptos,codigo',
            'fecha' => 'required|date',
        ];
        
        if ($concepto) {
            if ($concepto->requiere_cantidad) {
                $rules['cantidad'] = 'required|numeric';
            }
            
            if ($concepto->requiere_tipo_incidencia) {
                $rules['tipo_incidencia'] = 'required|string';
            }
            
            if ($concepto->requiere_periodo) {
                $rules['periodo'] = 'required|string';
            }
            
            if ($concepto->requiere_entrada_salida) {
                $rules['hora_entrada'] = 'required|date_format:H:i';
                $rules['hora_salida'] = 'required|date_format:H:i|after:hora_entrada';
            }
        }
        
        return Validator::make($data, $rules);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incidencia = Incidencia::with(['empleado', 'concepto'])->findOrFail($id);
        return response()->json($incidencia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $incidencia = Incidencia::findOrFail($id);
        $validator = $this->validarIncidencia($request->all());
        
        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }
        
        $incidencia->update($request->all());
        return response()->json($incidencia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incidencia = Incidencia::findOrFail($id);
        $incidencia->delete();
        return response()->json(null, 204);
    }
}
