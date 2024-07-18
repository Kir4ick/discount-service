<?php

namespace App\Middleware\CalculatePrice;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;

interface CalculatePriceInterface
{

    /**
     * @param CalculatePriceActionInput $input
     * @param callable(CalculatePriceActionInput, callable|null $next): CalculatePriceActionOutput $next
     * @return mixed
     */
    public function action(CalculatePriceActionInput $input, callable $next): CalculatePriceActionOutput;
}
