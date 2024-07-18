<?php

namespace App\Middleware\CalculatePrice;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;

abstract class AbstractCalculatePriceMiddleware implements CalculatePriceInterface
{
    public function __construct(
        protected readonly float $basePrice
    )
    {}

    protected function getMaxPriceDiscount(): float
    {
        return (float)PHP_INT_MAX;
    }

    abstract protected function getDiscount(): int;

    protected function getPriceDiscount(float $price, int $discount): float
    {
        return min($price / 100 * $discount, $this->getMaxPriceDiscount());
    }

    protected function calculateDiscount(float $price, int $discount): float
    {
        return $price - $this->getPriceDiscount($price, $discount);
    }
}
