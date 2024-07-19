<?php

namespace App\Middleware\CalculatePrice\Reservasion;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;

class ThirtyReservasionGroupMiddleware extends AbstractCalculatePriceReservasionMiddleware
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

    protected function setDiscountConditionKey(CalculatePriceActionInput $input): void
    {
        $now = new \DateTime();

        # Проверка на то, что было забронировано на нужные месяцы
        $startDate = new \DateTime();
        $startDate->setTime(0,0,0);
        $startDate->setDate((int)$startDate->format('Y') + 1, 1, 15);

        if ($input->getDateStart() < $startDate) {
            return;
        }

        $currentYear = (int)$now->format('Y');
        $paymentYear = (int)$input->getDatePayment()->format('Y');

        $paymentMonth = (int)$input->getDatePayment()->format('m');

        if ($paymentMonth <= 8 && $currentYear === $paymentYear) {
            $this->discountKey = self::FIRST;

            return;
        }

        if ($paymentMonth <= 9 && $currentYear === $paymentYear) {
            $this->discountKey = self::SECOND;

            return;
        }

        if ($paymentMonth <= 10 && $currentYear === $paymentYear) {
            $this->discountKey = self::THIRTY;
        }
    }

    protected function isImmediatelyReturn(): bool
    {
        return true;
    }
}
