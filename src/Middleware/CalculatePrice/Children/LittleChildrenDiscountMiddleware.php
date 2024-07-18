<?php

namespace App\Middleware\CalculatePrice\Children;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;

class LittleChildrenDiscountMiddleware extends AbstractCalculatePriceChildMiddleware
{

    protected function getConditionForDiscount(CalculatePriceActionInput $input): bool
    {
        return $input->getAge() >= 3 && $input->getAge() < 6;
    }

    protected function getDiscount(): int
    {
        return 80;
    }
}
