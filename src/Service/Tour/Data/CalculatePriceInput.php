<?php

namespace App\Service\Tour\Data;

use DateTimeInterface;

class CalculatePriceInput
{

    private float $basePrice;

    private DateTimeInterface $dateBirthday;

    private DateTimeInterface $dateStart;

    private DateTimeInterface $datePayment;

    public function __construct(
        float $price,
        DateTimeInterface $dateBirthday,
        DateTimeInterface $dateStart,
        DateTimeInterface $datePayment
    ) {
        $this->basePrice = $price;
        $this->dateBirthday = $dateBirthday;
        $this->dateStart = $dateStart;
        $this->datePayment = $datePayment;
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function getDateBirthday(): DateTimeInterface
    {
        return $this->dateBirthday;
    }

    public function getDateStart(): DateTimeInterface
    {
        return $this->dateStart;
    }

    public function getDatePayment(): DateTimeInterface
    {
        return $this->datePayment;
    }

}
