<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Customer;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Obtener lista de los clientes
        try {
            $customers = Customer::all();
            return ApiResponse::success($customers, "Clientes listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener los clientes", null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //      Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'identification_number' => 'required|string|max:255',
            'razon_social_bol'      => 'required|string|max:255',
            'name'                  => 'required|string|max:255',
            'lastname'              => 'required|string|max:255',
//            Table People
            'email'                 => 'required|string|max:255',
            'phone'                 => 'required|string|max:255',
            'mobile'                => 'required|string|max:255',
            'address_one'           => 'required|string|max:255',
            'address_two'           => 'required|string|max:255',
            'country'               => 'required|string|max:255',
            'state'                 => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'postal_code'           => 'required|string|max:255',
            'credit_limit'          => 'required|string|max:255',
            'created_by'            => 'required|string|',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion del cliente
            $customer = Customer::create([
                'identification_number' => $request->identification_number,
                'razon_social_bol'      => $request->razon_social_bol,
                'name'                  => $request->name,
                'lastname'              => $request->lastname,
                'created_by'            => $request->created_by,
            ]);

            $person = Person::create([
                'customer_id'   => $customer->id,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'mobile'        => $request->mobile,
                'address_one'   => $request->address_one,
                'address_two'   => $request->address_two,
                'country'       => $request->country,
                'state'         => $request->state,
                'city'          => $request->city,
                'postal_code'   => $request->postal_code,
                'credit_limit'  => $request->credit_limit,
                'created_by'    => $request->created_by,
            ]);
            return ApiResponse::success($customer + $person, "Cliente creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear al cliente", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);  // Busca el cliente, si no lo encuentra lanza una excepción
            return ApiResponse::success($customer, "Cliente encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Cliente no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener al cliente", null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //      Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'identification_number' => 'required|string|max:255',
            'razon_social_bol'      => 'required|string|max:255',
            'name'                  => 'required|string|max:255',
            'lastname'              => 'required|string|max:255',
//            Table People
            'email'                 => 'required|string|max:255',
            'phone'                 => 'required|string|max:255',
            'mobile'                => 'required|string|max:255',
            'address_one'           => 'required|string|max:255',
            'address_two'           => 'required|string|max:255',
            'country'               => 'required|string|max:255',
            'state'                 => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'postal_code'           => 'required|string|max:255',
            'credit_limit'          => 'required|string|max:255',
            'created_by'            => 'required|string|',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
            $customer = Customer::findOrFail($id);  // Busca al cliente, si no lo encuentra lanza una excepción
            $customer->update([
                'identification_number' => $request->identification_number ?? $customer->identification_number,
                'razon_social_bol'      => $request->razon_social_bol ?? $customer->razon_social_bol,
                'name'                  => $request->name ?? $customer->name,
                'lastname'              => $request->lastname ?? $customer->lastname,
                'created_by'            => $request->created_by ?? $customer->created_by,
            ]);

            $person = Person::where('customer_id' == $customer->id)->get();
            $person->update([
                'customer_id'   => $customer->id,
                'email'         => $request->email ?? $person->email,
                'phone'         => $request->phone ?? $person->phone,
                'mobile'        => $request->mobile ?? $person->mobile,
                'address_one'   => $request->address_one ?? $person->address_one,
                'address_two'   => $request->address_two ?? $person->address_two,
                'country'       => $request->country ?? $person->country,
                'state'         => $request->state ?? $person->state,
                'city'          => $request->city ?? $person->city,
                'postal_code'   => $request->postal_code ?? $person->postal_code,
                'credit_limit'  => $request->credit_limit ?? $person->credit_limit,
                'created_by'    => $request->created_by ?? $person->created_by,
            ]);
            return ApiResponse::success($customer + $person, "Cliente actualizado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Cliente no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al actualizar el cliente", null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);  // Busca el cliente, si no lo encuentra lanza una excepción
            $customer->delete();  // Elimina el cliente
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Cliente no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar al cliente", null, 500);
        }
    }
}
