<?php

namespace App\Middleware\CalculatePrice\Children;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;

class OldChildrenDiscountMiddleware extends AbstractCalculatePriceChildMiddleware
{

    protected function getConditionForDiscount(CalculatePriceActionInput $input): bool
    {
        return $input->getAge() >= 12 && $input->getAge() < 18;
    }

    protected function getDiscount(): int
    {
        return 10;
    }
}
