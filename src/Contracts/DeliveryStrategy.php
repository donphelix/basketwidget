<?php

namespace Donphelix\Widget\Contracts;

interface DeliveryStrategy
{
    public function calculateDelivery(float $total): float;
}