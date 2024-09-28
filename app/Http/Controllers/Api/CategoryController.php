<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Obtener lista de las categorias
        try {
            $categories = Brand::all();
            return ApiResponse::success($categories, "Marcas listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener las categorias", null, 500);
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
            'short_code'    => 'required|string|max:255',
            'created_by'    => 'required|string|',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion del usuario
            $category = Category::create([
                'name'          => $request->name,
                'short_code'    => $request->email,
                'created_by'    => $request->created_by,
            ]);
            return ApiResponse::success($category, "Categoria creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear la categoria", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción
            return ApiResponse::success($category, "Categoria encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Categoria no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener la categoria", null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //       Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'          => 'sometimes|required|string|max:255',
            'short_code'    => 'sometimes|required|string',
            'created_by'    => 'sometimes|required|',
        ]);

//        En caso de error en la validcacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validacion", $validator->errors(), 422);
        }

        try {
            $category = Category::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción

//            Actualizacion de datos
            $category->update([
                'name'          => $request->name ?? $category->name,
                'short_code'    => $request->short_code ?? $category->short_code,
                'created_by'    => $request->created_by ?? $category->created_by,
            ]);
            return ApiResponse::success($category, "Categoria actualizado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Categoria no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al actualizar la categoria", null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);  // Busca la marca, si no lo encuentra lanza una excepción
            $category->delete();  // Elimina el usuario
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Marca no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar la marca", null, 500);
        }
    }
}
