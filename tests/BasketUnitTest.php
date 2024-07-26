<?php

use Donphelix\Widget\Models\Catalog;
use Donphelix\Widget\Models\Product;
use Donphelix\Widget\Basket;
use Donphelix\Widget\StandardPricingStrategy;
use Donphelix\Widget\StandardDeliveryStrategy;
use PHPUnit\Framework\TestCase;

class BasketUnitTest extends TestCase
{
    private Catalog $catalog;

    protected function setUp(): void
    {
        $this->catalog = new Catalog();
        $this->catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
        $this->catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
        $this->catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));
    }

    public function testBasketTotal()
    {
        $pricingStrategy = new StandardPricingStrategy($this->catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($this->catalog->getProduct('B01'));
        $basket->add($this->catalog->getProduct('G01'));

        $this->assertEquals(37.85, $basket->getTotal());
    }

    public function testSpecialOffer()
    {
        $pricingStrategy = new StandardPricingStrategy($this->catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($this->catalog->getProduct('R01'));
        $basket->add($this->catalog->getProduct('R01'));

        $this->assertEquals(54.37, $basket->getTotal());
    }

    public function testFreeDelivery()
    {
        $pricingStrategy = new StandardPricingStrategy($this->catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($this->catalog->getProduct('R01'));
        $basket->add($this->catalog->getProduct('R01'));
        $basket->add($this->catalog->getProduct('R01'));

        $this->assertEquals(98.85, $basket->getTotal());
    }
}
