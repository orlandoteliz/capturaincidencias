<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConceptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conceptos = Concepto::all();
        return response()->json($conceptos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:conceptos,codigo',
            'nombre' => 'required|string|max:255',
            'requiere_cantidad' => 'boolean',
            'requiere_tipo_incidencia' => 'boolean',
            'requiere_periodo' => 'boolean',
            'requiere_entrada_salida' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $concepto = Concepto::create($request->all());
        return response()->json($concepto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $concepto = Concepto::findOrFail($id);
        return response()->json($concepto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $concepto = Concepto::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'codigo' => 'string|unique:conceptos,codigo,' . $id,
            'nombre' => 'string|max:255',
            'requiere_cantidad' => 'boolean',
            'requiere_tipo_incidencia' => 'boolean',
            'requiere_periodo' => 'boolean',
            'requiere_entrada_salida' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $concepto->update($request->all());
        return response()->json($concepto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concepto = Concepto::findOrFail($id);
        $concepto->delete();
        return response()->json(null, 204);
    }
}
