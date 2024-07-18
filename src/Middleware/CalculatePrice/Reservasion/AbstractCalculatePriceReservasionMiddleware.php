<?php

namespace App\Middleware\CalculatePrice\Reservasion;

use App\Middleware\CalculatePrice\AbstractCalculatePriceMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;

abstract class AbstractCalculatePriceReservasionMiddleware extends AbstractCalculatePriceMiddleware
{

    /**
     * @return array<mixed, int>
     */
    abstract protected function getDiscountConditions(): array;

    protected ?int $discountKey = null;

    protected function getDiscount(): int
    {
        $conditions = $this->getDiscountConditions();

        return $this->discountKey == null ? 0 : ($conditions[$this->discountKey] ?? 0);
    }

    protected function getMaxPriceDiscount(): float
    {
        return 1500;
    }

    protected function isImmediatelyReturn(): bool
    {
        return false;
    }

    abstract protected function setDiscountConditionKey(CalculatePriceActionInput $input): void;

    public function action(CalculatePriceActionInput $input, ?callable $next): CalculatePriceActionOutput
    {
        $this->setDiscountConditionKey($input);

        $discount = $this->getDiscount();
        if ($discount === 0) {
            return $next($input);
        }

        $newPrice = $this->calculateDiscount($input->getPrice(), $discount);

        // Я не знаю точно, скидка в 1 и 3 коейсе должна ли складываться
        if ($this->isImmediatelyReturn()) {
            return new CalculatePriceActionOutput($newPrice);
        }

        return $next(
            new CalculatePriceActionInput(
                $newPrice,
                $input->getAge(),
                $input->getDateStart(),
                $input->getDatePayment()
            )
        );
    }
}
