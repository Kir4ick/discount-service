<?php

namespace App\Middleware\CalculatePrice\Children;

use App\Middleware\CalculatePrice\AbstractCalculatePriceMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;

class MiddleChildrenDiscountMiddleware extends AbstractCalculatePriceChildMiddleware
{

    protected function getConditionForDiscount(CalculatePriceActionInput $input): bool
    {
        return $input->getAge() >= 6 && $input->getAge() < 12;
    }

    protected function getDiscount(): int
    {
        return 30;
    }

    protected function getMaxPriceDiscount(): float
    {
        return 4500;
    }
}
