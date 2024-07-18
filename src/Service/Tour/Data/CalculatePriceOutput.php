<?php

namespace App\Service\Tour\Data;

use DateTimeInterface;

class CalculatePriceOutput
{
    private float $price;

    public function __construct(float $price)
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

}
