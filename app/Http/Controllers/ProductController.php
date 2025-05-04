<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Devuelve todos los productos
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'No tienes permisos para crear un producto.'], 403);
        }

        $validated = $request->validated();

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Producto creado correctamente.',
            'product' => $product,
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Devuelve un producto específico
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Actualiza el producto con los datos validados
        $product->update($request->validated());

        // Devuelve la respuesta con el producto actualizado
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Elimina el producto
        $product->delete();

        // Devuelve una respuesta de éxito
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}

