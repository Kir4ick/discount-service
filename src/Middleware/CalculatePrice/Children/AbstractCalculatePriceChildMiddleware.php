<?php

namespace App\Middleware\CalculatePrice\Children;

use App\Middleware\CalculatePrice\AbstractCalculatePriceMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;

abstract class AbstractCalculatePriceChildMiddleware extends AbstractCalculatePriceMiddleware
{

    abstract protected function getConditionForDiscount(CalculatePriceActionInput $input): bool;

    public function action(CalculatePriceActionInput $input, callable $next): CalculatePriceActionOutput
    {
        if ($this->getConditionForDiscount($input)) {
            $newPrice = $this->calculateDiscount($input->getPrice(), $this->getDiscount());

            return $next(new CalculatePriceActionInput(
                $newPrice,
                $input->getAge(),
                $input->getDateStart(),
                $input->getDatePayment()
            ));
        }

        return $next($input);
    }
}
