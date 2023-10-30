<?php

namespace Domain\Cart\Http\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class CartData extends Data
{
    #[Computed]
    public array $items;

    #[Computed]
    public int $total;

    #[Computed]
    public int $subTotal;

    #[Computed]
    public int $tax;

    public function __construct(
        private readonly array $cart,
    )
    {
        $this->items = $this->getItems();
        $this->subTotal = $this->getSubTotal();
        $this->tax = $this->getTax();
        $this->total = $this->getTotal();
    }

    /**
     * @return array
     */
    private function getItems(): array
    {
        $items = [];
        foreach ($this->cart as $item) {
            $items[] = [
                'id' => $item['product']['id'],
                'product' => $item['product']['name'],
                'quantity' => $item['quantity'],
                'per_item' => $item['product']['price'],
                'price' => $item['product']['price'] * $item['quantity'],
                'image' => 'https://via.placeholder.com/150'
            ];
        }
        return $items;
    }

    /**
     * @return float|int
     */
    private function getTax(): float|int
    {
        $vat = config('cart.vat');
        return $this->subTotal * $vat / 100;
    }

    /**
     * @return mixed
     */
    private function getSubTotal(): mixed
    {
        $items = collect($this->items);
        return $items->sum('price');
    }

    /**
     * @return float|int|mixed
     */
    private function getTotal(): mixed
    {
        return $this->subTotal + $this->tax;
    }
}
