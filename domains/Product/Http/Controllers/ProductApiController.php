<?php

namespace Domain\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\Product\Http\Data\ProductData;
use Domain\Product\Http\Requests\StoreProductRequest;
use Domain\Product\Http\Requests\UpdateProductRequest;
use Domain\Product\Http\Resources\ProductResource;
use Domain\Product\Models\Product;
use Domain\Product\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class ProductApiController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/api/products",
     *      summary="Get all products",
     *      tags={"Products"},
     *      security={{"token":{}}},
     *      @OA\Parameter( name="relations[]", in="query", description="Relations to include", required=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="string"),
     *          ),
     *      ),
     *      @OA\Parameter( name="page", in="query", description="Page number", required=false,
     *          @OA\Schema(
     *             type="integer",
     *             format="int32"
     *          ),
     *      ),
     *      @OA\Parameter( name="per_page", in="query", description="Per page", required=false,
     *           @OA\Schema(
     *              type="integer",
     *              format="int32"
     *           ),
     *       ),
     *       @OA\Parameter( name="name", in="query", description="Product Name", required=false,
     *            @OA\Schema(
     *               type="string",
     *            ),
     *      ),
     *       @OA\Parameter( name="slug", in="query", description="Product Slug", required=false,
     *           @OA\Schema(
     *               type="string",
     *           ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Products list",
     *      ),
     *  )
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productService->paginate(
            $request,
            $request->get('relations', []))
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/products/{product}",
     *     summary="Get product data",
     *     tags={"Products"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *         @OA\Schema( type="integer", format="int32" )
     *     ),
     *     @OA\Parameter( name="relations[]", in="query", description="Relations to include", required=false,
     *         @OA\Schema( type="array", @OA\Items(type="string") )
     *     ),
     *     @OA\Response( response="200", description="Product data" )
     * )
     */
    public function show(Request $request, Product $product): ProductResource
    {
        return new ProductResource(
            $this->productService->findById(
                $product->id,
                $request->get('relations', [])
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/products",
     *      summary="Create product",
     *      tags={"Products"},
     *      security={{"token":{}}},
     *      @OA\RequestBody( description="Product data", required=true,
     *         @OA\JsonContent(
     *             @OA\Property( property="name", type="string", example="Product name" ),
     *             @OA\Property( property="slug", type="string", example="product-name" ),
     *             @OA\Property( property="price", type="number", example="10" ),
     *             @OA\Property( property="is_active", type="boolean", example="true" ),
     *             @OA\Property( property="category_id", type="integer", example="1" ),
     *         )
     *      ),
     *      @OA\Response( response="200", description="Product data" )
     *  )
     *
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->create(
                ProductData::from($request)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/products/{product}",
     *     summary="Update product data",
     *     tags={"Products"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *        @OA\Schema( type="integer", format="int32" )
     *     ),
     *     @OA\RequestBody( description="Product data", required=true,
     *        @OA\JsonContent(
     *            @OA\Property( property="name", type="string", example="Product name" ),
     *            @OA\Property( property="slug", type="string", example="product-name" ),
     *            @OA\Property( property="price", type="number", example="10" ),
     *            @OA\Property( property="is_active", type="boolean", example="true" ),
     *            @OA\Property( property="category_id", type="integer", example="1" ),
     *        )
     *     ),
     *     @OA\Response( response="200", description="Product data" )
     * )
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        return new ProductResource($this->productService->update(
            ProductData::from($request),
            $product->id
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     summary="Delete a product",
     *     tags={"Products"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *         @OA\Schema( type="integer", format="int32" )
     *     ),
     *     @OA\Response( response="200", description="Product deleted successfully" )
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        $deleted = $this->productService->delete($product->id);
        if ($deleted) {
            return response()->json(['message' => 'Product deleted successfully']);
        }

        return response()->json(['message' => 'Product not deleted'], 400);
    }
}
