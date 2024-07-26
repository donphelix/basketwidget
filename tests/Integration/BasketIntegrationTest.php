<?php
namespace Integration;

use Donphelix\Widget\Models\Catalog;
use Donphelix\Widget\Models\Product;
use Donphelix\Widget\Basket;
use Donphelix\Widget\StandardPricingStrategy;
use Donphelix\Widget\StandardDeliveryStrategy;
use PHPUnit\Framework\TestCase;

class BasketIntegrationTest extends TestCase
{
    public function testCompleteBasketFlow()
    {
        $catalog = new Catalog();
        $catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
        $catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
        $catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

        $pricingStrategy = new StandardPricingStrategy($catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($catalog->getProduct('B01'));
        $basket->add($catalog->getProduct('G01'));
        $basket->add($catalog->getProduct('R01'));

        $this->assertEquals(65.85, $basket->getTotal());
    }

    public function testMultipleSpecialOffers()
    {
        $catalog = new Catalog();
        $catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
        $catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
        $catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

        $pricingStrategy = new StandardPricingStrategy($catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('R01'));

        $this->assertEquals(109.74, $basket->getTotal());
    }

    public function testBasketWithFreeDelivery()
    {
        $catalog = new Catalog();
        $catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
        $catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
        $catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

        $pricingStrategy = new StandardPricingStrategy($catalog);
        $deliveryStrategy = new StandardDeliveryStrategy();
        $basket = new Basket($pricingStrategy, $deliveryStrategy);

        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('R01'));
        $basket->add($catalog->getProduct('G01'));

        $this->assertEquals(116.80, $basket->getTotal());
    }
}
