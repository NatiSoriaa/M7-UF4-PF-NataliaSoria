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
     * @OA\Get(
     *     path="/api/products",
     *     summary="Llista tots els productes",
     *     @OA\Response(
     *         response=200,
     *         description="Llista de productes"
     *     )
     * )
     */
    public function index()
    {
        // Devuelve todos los productos
        return response()->json(Product::all());
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crea un nou producte",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Producte 1"),
     *             @OA\Property(property="price", type="number", example=100.50),
     *             @OA\Property(property="description", type="string", example="Descripció del producte")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producte creat correctament"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tens permisos per crear un producte"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Mostra un producte específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producte",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalls del producte"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producte no trobat"
     *     )
     * )
     */
    public function show(Product $product)
    {
        // Devuelve un producto específico
        return response()->json($product);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Actualitza un producte existent",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producte",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Producte actualitzat"),
     *             @OA\Property(property="price", type="number", example=150.75),
     *             @OA\Property(property="description", type="string", example="Descripció actualitzada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producte actualitzat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producte no trobat"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Actualiza el producto con los datos validados
        $product->update($request->validated());

        // Devuelve la respuesta con el producto actualizado
        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Elimina un producte",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producte",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producte eliminat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producte no trobat"
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        // Elimina el producto
        $product->delete();

        // Devuelve una respuesta de éxito
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}