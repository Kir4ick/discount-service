<?php

namespace App\Middleware\CalculatePrice\Data;

class CalculatePriceActionOutput
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
