<?php

namespace Donphelix\Widget;

use Donphelix\Widget\Contracts\DeliveryStrategy;
use Donphelix\Widget\Contracts\PricingStrategy;
use Donphelix\Widget\Models\Product;

class Basket {
    private array $items = [];
    private PricingStrategy $pricingStrategy;
    private DeliveryStrategy $deliveryStrategy;
    private float $total = 0;
    private float $deliveryCharge = 0;

    public function __construct(PricingStrategy $pricingStrategy, DeliveryStrategy $deliveryStrategy) {
        $this->pricingStrategy = $pricingStrategy;
        $this->deliveryStrategy = $deliveryStrategy;
    }

    public function add(Product $product): void {
        $this->items[] = $product;
    }

    public function getTotal(): float {
        $this->total = $this->pricingStrategy->calculateTotal($this->items);
        $this->deliveryCharge = $this->deliveryStrategy->calculateDelivery($this->total);
        $totalAmount = $this->total + $this->deliveryCharge;
        return floor($totalAmount * 100) / 100;
    }


}