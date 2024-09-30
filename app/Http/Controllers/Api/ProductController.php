<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //      Obtener lista de los productos
        try {
            $products = Product::all();
            return ApiResponse::success($products, "Productos listados correctamente");
        }catch (\Exception $exception){
            return ApiResponse::error("Error al obtener los productos", null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //      Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|max:255|unique:products,sku',
            'unit_id'           => 'required',
            'brand_id'          => 'required',
            'category_id'       => 'required',
            'enable_stock'      => 'required',
            'alert_quantity'    => 'required',
            'pathImage'         => 'required',
            'purchase_price'    => 'required',
            'margin_of_gain'    => 'required',
            'sale_price'        => 'required',
            'created_by'        => 'required',
        ]);

//      En caso de error en la validacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validación", $validator->errors(), 422);
        }

        try {
//          Creacion del producto
            $category = Category::create([
                'name'              => $request->name,
                'sku'               => $request->sku,
                'unit_id'           => $request->unit_id,
                'brand_id'          => $request->brand_id,
                'category_id'       => $request->category_id,
                'enable_stock'      => $request->enable_stock,
                'alert_quantity'    => $request->alert_quantity,
                'pathImage'         => $request->pathImage,
                'purchase_price'    => $request->purchase_price,
                'margin_of_gain'    => $request->margin_of_gain,
                'sale_price'        => $request->sale_price,
                'created_by'        => $request->created_by,
            ]);
            return ApiResponse::success($category, "Producto creado exitosamente", 201);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al crear el producto", null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);  // Busca el producto, si no lo encuentra lanza una excepción
            return ApiResponse::success($product, "Producto encontrado");
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Producto no encontrado", null, 404);
        }catch (\Exception $exception) {
            return ApiResponse::error("Error al obtener el producto", null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //        Validacion de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|max:255|unique:products,sku' . $id,
            'unit_id'           => 'required',
            'brand_id'          => 'required',
            'category_id'       => 'required',
            'enable_stock'      => 'required',
            'alert_quantity'    => 'required',
            'pathImage'         => 'required',
            'purchase_price'    => 'required',
            'margin_of_gain'    => 'required',
            'sale_price'        => 'required',
            'created_by'        => 'required',
        ]);

//        En caso de error en la validcacion
        if ($validator->fails()) {
            return ApiResponse::error("Error de validacion", $validator->errors(), 422);
        }

        try {
            $product = Product::findOrFail($id);  // Busca el producto, si no lo encuentra lanza una excepción

//            Actualizacion de datos
            $product->update([
                'name'              => $request->name ?? $product->name,
                'sku'               => $request->sku ?? $product->sku,
                'unit_id'           => $request->unit_id ?? $product->unit_id,
                'brand_id'          => $request->brand_id ?? $product->brand_id,
                'category_id'       => $request->category_id ?? $product->category_id,
                'enable_stock'      => $request->enable_stock ?? $product->enable_stock,
                'alert_quantity'    => $request->alert_quantity ?? $product->alert_quantity,
                'pathImage'         => $request->pathImage ?? $product->pathImage,
                'purchase_price'    => $request->purchase_price ?? $product->purchase_price,
                'margin_of_gain'    => $request->margin_of_gain ?? $product->margin_of_gain,
                'sale_price'        => $request->sale_price ?? $product->sale_price,
                'created_by'        => $request->created_by ?? $product->created_by,
            ]);
            return ApiResponse::success($product, "Producto actualizado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Producto no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al actualizar el producto", null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);  // Busca el producto, si no lo encuentra lanza una excepción
            $product->delete();  // Elimina el usuario
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return ApiResponse::error("Usuario no encontrado", null, 404);
        } catch (\Exception $exception) {
            return ApiResponse::error("Error al eliminar el usuario", null, 500);
        }
    }
}
