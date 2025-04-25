<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::all();
        return response()->json($empleados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_empleado' => 'required|string|unique:empleados,numero_empleado',
            'nombre' => 'required|string|max:255',
            'departamento' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $empleado = Empleado::create($request->all());
        return response()->json($empleado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'numero_empleado' => 'string|unique:empleados,numero_empleado,' . $id,
            'nombre' => 'string|max:255',
            'departamento' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $empleado->update($request->all());
        return response()->json($empleado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return response()->json(null, 204);
    }
}
