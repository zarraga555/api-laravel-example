<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\UnitOfMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Obtener lista de las Unidades de medida
        try {
            $unitMeasure = UnitOfMeasure::all();
            return ApiResponse::success($unitMeasure, "Unidades de medida listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener las unidades de medida", null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //      Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'acronym'       => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'created_by'    => 'required|string|',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion de la unidad de medida
            $unitMeasure = UnitOfMeasure::create([
                'name'          => $request->name,
                'short_code'    => $request->email,
                'description'   => $request->description,
                'created_by'    => $request->created_by,
            ]);
            return ApiResponse::success($unitMeasure, "Unidad de medida creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear la unidad de medida", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $unitMeasure = UnitOfMeasure::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción
            return ApiResponse::success($unitMeasure, "Unidad de medida encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Unidad de medida no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener la unidad de medida", null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //       Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'acronym'       => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'created_by'    => 'required|string|',
        ]);

//        En caso de error en la validcacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validacion", $validator->errors(), 422);
        }

        try {
            $unitMeasure = UnitOfMeasure::findOrFail($id);  // Busca la unidad de medida, si no lo encuentra lanza una excepción

//            Actualizacion de datos
            $unitMeasure->update([
                'name'          => $request->name ?? $unitMeasure->name,
                'short_code'    => $request->short_code ?? $unitMeasure->short_code,
                'created_by'    => $request->created_by ?? $unitMeasure->created_by,
                'description'   => $request->created_by ?? $unitMeasure->description,
            ]);
            return ApiResponse::success($unitMeasure, "Unidad de medida actualizado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Unidad de medida no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al actualizar la unidad de medida", null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $unitMeasure = UnitOfMeasure::findOrFail($id);  // Busca la unidad de medida, si no lo encuentra lanza una excepción
            $unitMeasure->delete();  // Elimina la unidad de medida
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Unidad de medida no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar la unidad de medida", null, 500);
        }
    }
}
