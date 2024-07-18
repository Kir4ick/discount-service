<?php

namespace App\Service\Tour;

use App\Service\Tour\Data\CalculatePriceInput;
use App\Service\Tour\Data\CalculatePriceOutput;

interface TourServiceInterface
{
    public function calculatePrice(CalculatePriceInput $input): CalculatePriceOutput;
}
