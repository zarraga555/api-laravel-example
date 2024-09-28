<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//      Obtener lista de usuarios
        try {
            $users = User::all();
            return ApiResponse::success($users, "Usuarios listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener usuarios", null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//      Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion del usuario
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password) // Encriptamos la contraseña
            ]);
            return ApiResponse::success($user, "Usuario creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear el usuario", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción
            return ApiResponse::success($user, "Usuario encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Usuario no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener el usuario", null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
//        Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'      => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|email|unique:users,email,' . $id,
            'password'  => 'sometimes|required|min:8',
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
            $usuario = User::findOrFail($id);  // Busca el usuario, si no lo encuentra lanza una excepción
            $usuario->delete();  // Elimina el usuario
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Usuario no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar el usuario", null, 500);
        }
    }
}
