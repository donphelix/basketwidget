<?php

namespace Donphelix\Widget;

use Donphelix\Widget\Contracts\PricingStrategy;
use Donphelix\Widget\Models\Catalog;

class StandardPricingStrategy implements PricingStrategy
{
    private Catalog $catalog;

    /**
     * @param Catalog $catalog
     */
    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function calculateTotal(array $items): float
    {
        $total = array_reduce($items, fn($carry, $item) => $carry + $item->getPrice(), 0);

        // Special offer: Buy one red widget, get the second half price
        $redWidgets = array_filter($items, fn($item) => $item->getCode() === 'R01');
        $redWidgetCount = count($redWidgets);

        if ($redWidgetCount >= 2) {
            $redWidget = $this->catalog->getProduct('R01');
            $total -= ($redWidget->getPrice() / 2);
        }

        return $total;
    }
}