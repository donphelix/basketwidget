<?php

namespace Donphelix\Widget;

use Donphelix\Widget\Contracts\DeliveryStrategy;

class StandardDeliveryStrategy implements DeliveryStrategy
{
    public function calculateDelivery(float $total): float
    {
        if ($total < 50) {
            return 4.95;
        } elseif ($total < 90) {
            return 2.95;
        } else {
            return 0;
        }
    }
}