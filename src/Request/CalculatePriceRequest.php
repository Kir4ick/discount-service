<?php

declare(strict_types=1);

namespace App\Request;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class CalculatePriceRequest
{

    #[NotBlank]
    #[Positive]
    private float $basePrice;

    #[NotBlank]
    #[Date]
    private string $dateBirthday;

    #[NotBlank]
    #[Date]
    private string $dateStart;

    #[NotBlank]
    #[Date]
    private string $datePayment;

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function getDateBirthday(): DateTimeInterface
    {
        return new \DateTime($this->dateBirthday);
    }

    public function getDateStart(): DateTimeInterface
    {
        return new \DateTime($this->dateStart);
    }

    public function getDatePayment(): DateTimeInterface
    {
        return new \DateTime($this->datePayment);
    }

    public function setBasePrice(float $basePrice): CalculatePriceRequest
    {
        $this->basePrice = $basePrice;
        return $this;
    }

    public function setDateBirthday(string $dateBirthday): CalculatePriceRequest
    {
        $this->dateBirthday = $dateBirthday;
        return $this;
    }

    public function setDateStart(string $dateStart): CalculatePriceRequest
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function setDatePayment(string $datePayment): CalculatePriceRequest
    {
        $this->datePayment = $datePayment;
        return $this;
    }

}
