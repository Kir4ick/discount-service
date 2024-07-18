<?php

namespace App\Response;

class CalculatePriceResponse
{

    private ?float $price = null;

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): CalculatePriceResponse
    {
        $this->price = $price;
        return $this;
    }

}
