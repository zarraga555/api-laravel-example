<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Obtener lista de las marcas
        try {
            $brands = Brand::all();
            return ApiResponse::success($brands, "Marcas listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener las marcas", null, 500);
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
            'description'   => 'required|string|max:255',
            'created_by'    => 'required|string|',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion del usuario
            $brand = Brand::create([
                'name'          => $request->name,
                'description'   => $request->email,
                'created_by'    => $request->created_by,
            ]);
            return ApiResponse::success($brand, "Marca creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear la marca", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción
            return ApiResponse::success($brand, "Marca encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Marca no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener la marca", null, 500);
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
            'description'   => 'sometimes|required|string',
            'password'      => 'sometimes|required|',
        ]);

//        En caso de error en la validcacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validacion", $validator->errors(), 422);
        }

        try {
            $user = User::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción

//            Actualizacion de datos
            $user->update([
                'name'      => $request->name ?? $user->name,
                'email'     => $request->email ?? $user->email,
                'password'  => $request->password ? Hash::make($request->password) : $user->password,
            ]);
            return ApiResponse::success($user, "Usuario actualizado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Usuario no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al actualizar el usuario", null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);  // Busca la marca, si no lo encuentra lanza una excepción
            $brand->delete();  // Elimina el usuario
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Marca no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar la marca", null, 500);
        }
    }
}
