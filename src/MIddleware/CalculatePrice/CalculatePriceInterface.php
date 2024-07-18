<?php

namespace App\Middleware\CalculatePrice;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;
use App\Service\Tour\Data\CalculatePriceInput;

interface CalculatePriceInterface
{

    /**
     * @param CalculatePriceInput $input
     * @param callable(CalculatePriceInput, callable|null $next): CalculatePriceActionOutput|null $next
     * @return mixed
     */
    public function action(CalculatePriceInput $input, ?callable $next): CalculatePriceActionOutput;
}
