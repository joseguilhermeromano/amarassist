<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(name="Products")
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Listar todos os produtos",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do produto"),
     *                 @OA\Property(property="title", type="string", description="Título do produto"),
     *                 @OA\Property(property="sale_price", type="number", format="float", description="Preço de venda"),
     *                 @OA\Property(property="cost", type="number", format="float", description="Custo do produto"),
     *                 @OA\Property(property="description", type="string", description="Descrição do produto"),
     *                 @OA\Property(property="images", type="array", @OA\Items(type="string"), description="Imagens do produto")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Criar um novo produto",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "sale_price", "cost", "description", "images"},
     *             @OA\Property(property="title", type="string", example="Produto Exemplo"),
     *             @OA\Property(property="sale_price", type="number", format="float", example=120.00),
     *             @OA\Property(property="cost", type="number", format="float", example=100.00),
     *             @OA\Property(property="description", type="string", example="<p>Descrição do produto</p>"),
     *             @OA\Property(property="images", type="array", @OA\Items(type="string", example="imagem1.jpg"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID do produto"),
     *             @OA\Property(property="title", type="string", description="Título do produto"),
     *             @OA\Property(property="sale_price", type="number", format="float", description="Preço de venda"),
     *             @OA\Property(property="cost", type="number", format="float", description="Custo do produto"),
     *             @OA\Property(property="description", type="string", description="Descrição do produto"),
     *             @OA\Property(property="images", type="array", @OA\Items(type="string"), description="Imagens do produto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sale_price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value < $request->cost * 1.10) {
                        $fail('O preço de venda deve ser pelo menos 10% maior que o custo.');
                    }
                },
            ],
            'cost' => 'required|numeric',
            'description' => 'required|string|regex:/<[a-z][\s\S]*>/i',
            'images' => 'required|array',
            'images.*' => 'url', // Valida que cada item do array é uma URL válida
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create([
            'title' => $request->title,
            'sale_price' => $request->sale_price,
            'cost' => $request->cost,
            'description' => $request->description,
            'images' => json_encode($request->images),
        ]);

        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Atualizar um produto",
     *     tags={"Products"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID do produto", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Produto Atualizado"),
     *             @OA\Property(property="sale_price", type="number", format="float", example=130.00),
     *             @OA\Property(property="cost", type="number", format="float", example=110.00),
     *             @OA\Property(property="description", type="string", example="<p>Descrição atualizada</p>"),
     *             @OA\Property(property="images", type="array", @OA\Items(type="string", example="imagem2.jpg"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID do produto"),
     *             @OA\Property(property="title", type="string", description="Título do produto"),
     *             @OA\Property(property="sale_price", type="number", format="float", description="Preço de venda"),
     *             @OA\Property(property="cost", type="number", format="float", description="Custo do produto"),
     *             @OA\Property(property="description", type="string", description="Descrição do produto"),
     *             @OA\Property(property="images", type="array", @OA\Items(type="string"), description="Imagens do produto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sale_price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value < $request->cost * 1.10) {
                        $fail('O preço de venda deve ser pelo menos 10% maior que o custo.');
                    }
                },
            ],
            'cost' => 'required|numeric',
            'description' => 'required|string|regex:/<[a-z][\s\S]*>/i',
            'images' => 'required|array',
            'images.*' => 'url', // Valida que cada item do array é uma URL válida
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product->update([
            'title' => $request->title,
            'sale_price' => $request->sale_price,
            'cost' => $request->cost,
            'description' => $request->description,
            'images' => json_encode($request->images),
        ]);

        return response()->json($product, 200);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Remover um produto",
     *     tags={"Products"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID do produto", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Produto removido com sucesso"),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
