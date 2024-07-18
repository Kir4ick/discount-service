<?php

namespace App\Middleware\CalculatePrice\Reservasion;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;

class FirstReservasionGroupMiddleware extends AbstractCalculatePriceReservasionMiddleware
{

    private const FIRST = 1;

    private const SECOND = 2;

    private const THIRTY = 3;

    protected function getDiscountConditions(): array
    {
        return [
            self::FIRST => 7,
            self::SECOND => 5,
            self::THIRTY => 3
        ];
    }

    protected function isImmediatelyReturn(): bool
    {
        return true;
    }

    protected function setDiscountConditionKey(CalculatePriceActionInput $input): void
    {
        $now = new \DateTime();

        # Проверка на то, что было забронировано на нужные месяцы
        $minDate = new \DateTime();
        $minDate->setTime(0,0,0);
        $minDate->setDate((int)$minDate->format('Y') + 1, 4, 1);

        $maxDate = new \DateTime();
        $maxDate->setTime(0,0,0);
        $maxDate->setDate((int)$maxDate->format('Y') + 1, 9, 30);

        if ($input->getDateStart() > $maxDate || $input->getDateStart() < $minDate) {
            return;
        }

        $currentYear = (int)$now->format('Y');
        $paymentYear = (int)$input->getDatePayment()->format('Y');

        $paymentMonth = (int)$input->getDatePayment()->format('m');

        if ($paymentMonth <= 11 && $currentYear === $paymentYear) {
            $this->discountKey = self::FIRST;

            return;
        }

        if ($paymentMonth <= 12 && $currentYear === $paymentYear) {
            $this->discountKey = self::FIRST;

            return;
        }

        if ($paymentMonth <= 1 && ($currentYear + 1) === $paymentYear) {
            $this->discountKey = self::FIRST;
        }
    }
}
