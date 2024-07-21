<?php

namespace Donphelix\Widget\Contracts;

interface PricingStrategy
{
    public function calculateTotal(array $items): float;
}