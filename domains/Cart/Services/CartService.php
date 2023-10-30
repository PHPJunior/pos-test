<?php

namespace Domain\Cart\Services;

use Domain\Cart\Http\Data\CartData;
use Domain\Product\Models\Product;

class CartService
{
    /**
     * @var \Closure|mixed|object|null
     */
    private mixed $cart;

    public function __construct()
    {
        $this->cart = cache()->get('cart', []);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function updateProductQty(Product $product, int $quantity = 1): static
    {
        $this->cart[$product->id] = [
            'product' => $product,
            'quantity' => $quantity
        ];
        cache()->put('cart', $this->cart);

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): static
    {
        if (isset($this->cart[$product->id])) {
            $this->cart[$product->id]['quantity']++;
        } else {
            $this->cart[$product->id] = [
                'product' => $product,
                'quantity' => 1
            ];
        }
        cache()->put('cart', $this->cart);

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): static
    {
        unset($this->cart[$product->id]);
        cache()->put('cart', $this->cart);

        return $this;
    }

    /**
     * @return CartData
     */
    public function getCart(): CartData
    {
        return new CartData($this->cart);
    }

    /**
     * @return CartData
     */
    public function clearCart(): CartData
    {
        cache()->forget('cart');
        return $this->getCart();
    }
}
