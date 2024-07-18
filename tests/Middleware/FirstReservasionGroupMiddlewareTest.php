<?php

namespace App\Tests\Middleware;

use App\Middleware\CalculatePrice\Children\LittleChildrenDiscountMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;
use App\Middleware\CalculatePrice\Reservasion\FirstReservasionGroupMiddleware;
use PHPUnit\Framework\TestCase;

class FirstReservasionGroupMiddlewareTest extends TestCase
{
    public function testDifferenceSuccess(): void
    {
        $middleware = new FirstReservasionGroupMiddleware(0);

        $price = 1000;

        $now = new \DateTime();

        $input = new CalculatePriceActionInput(
            $price,
            4,
            (new \DateTime())->setDate((int)$now->format('Y') + 1, 5, 9),
            (new \DateTime())->setDate((int)$now->format('Y'), 11, 9)
        );

        $result = $middleware->action(
            $input,
            fn(CalculatePriceActionInput $input) => new CalculatePriceActionOutput($input->getPrice())
        );

        $this->assertNotEquals($price, $result->getPrice());
    }

    public function testDifferenceFailedTest(): void
    {
        $middleware = new FirstReservasionGroupMiddleware(0);

        $price = 1000;

        $now = new \DateTime();

        $input = new CalculatePriceActionInput(
            $price,
            4,
            (new \DateTime())->setDate((int)$now->format('Y'), 5, 9),
            (new \DateTime())->setDate((int)$now->format('Y'), 11, 9)
        );

        $result = $middleware->action(
            $input,
            fn(CalculatePriceActionInput $input) => new CalculatePriceActionOutput($input->getPrice())
        );

        $this->assertEquals($price, $result->getPrice());
    }
}
