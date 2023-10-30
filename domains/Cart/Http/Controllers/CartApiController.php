<?php

namespace Domain\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\Cart\Http\Data\CartData;
use Domain\Cart\Http\Requests\UpdateCartRequest;
use Domain\Cart\Services\CartService;
use Domain\Product\Models\Product;
use OpenApi\Annotations as OA;

class CartApiController extends Controller
{

    public function __construct(private readonly CartService $cartService)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/cart",
     *     summary="Get cart data",
     *     tags={"Cart"},
     *     security={{"token":{}}},
     *     @OA\Response(
     *          response="200",
     *          description="Cart data",
     *     )
     * )
     *
     * @return CartData
     */
    public function index(): CartData
    {
        return $this->cartService->getCart();
    }

    /**
     * @OA\Post(
     *     path="/api/cart/{product}",
     *     summary="Add product to cart",
     *     tags={"Cart"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *         @OA\Schema( type="integer", format="int32" )
     *    ),
     *    @OA\Response( response="200", description="Cart data" )
     * )
     *
     * @param Product $product
     * @return CartData
     */
    public function store(Product $product): CartData
    {
        return $this->cartService->addProduct($product)->getCart();
    }

    /**
     * @OA\Put(
     *     path="/api/cart/{product}",
     *     summary="Update cart data",
     *     tags={"Cart"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *          @OA\Schema( type="integer", format="int32" )
     *     ),
     *     @OA\RequestBody( description="Quantity", required=true,
     *          @OA\JsonContent(
     *              @OA\Property( property="qty", type="integer", format="int32", example="1", minimum="1" )
     *          )
     *     ),
     *     @OA\Response( response="200", description="Cart data" )
     * ),
     *
     * @param UpdateCartRequest $request
     * @param Product $product
     * @return CartData
     */
    public function update(UpdateCartRequest $request, Product $product): CartData
    {
        return $this->cartService->updateProductQty($product, $request->get('qty'))->getCart();
    }

    /**
     * @OA\Delete(
     *     path="/api/cart/{product}",
     *     summary="Remove product from cart",
     *     tags={"Cart"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="product", in="path", description="Product ID", required=true,
     *         @OA\Schema( type="integer", format="int32" )
     *    ),
     *     @OA\Response( response="200", description="Cart data" )
     * )
     *
     * @param Product $product
     * @return CartData
     */
    public function destroy(Product $product): CartData
    {
        return $this->cartService->removeProduct($product)->getCart();
    }

    /**
     * @OA\Delete(
     *     path="/api/cart",
     *     summary="Clear cart",
     *     tags={"Cart"},
     *     security={{"token":{}}},
     *     @OA\Response( response="200", description="Cart data" )
     * )
     *
     * @return CartData
     */
    public function clear(): CartData
    {
        return $this->cartService->clearCart();
    }
}
