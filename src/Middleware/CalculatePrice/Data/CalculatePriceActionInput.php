<?php

namespace App\Middleware\CalculatePrice\Data;

use DateTimeInterface;

class CalculatePriceActionInput
{
    private float $price;

    private int $age;

    private DateTimeInterface $dateStart;

    private DateTimeInterface $datePayment;

    public function __construct(
        float $price,
        int $age,
        DateTimeInterface $dateStart,
        DateTimeInterface $datePayment
    ) {
        $this->price = $price;
        $this->age = $age;
        $this->dateStart = $dateStart;
        $this->datePayment = $datePayment;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAge(): int
    {
        return $this->age;
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
