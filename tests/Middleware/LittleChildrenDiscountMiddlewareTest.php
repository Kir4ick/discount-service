<?php

namespace App\Tests\Middleware;

use App\Middleware\CalculatePrice\Children\LittleChildrenDiscountMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;
use PHPUnit\Framework\TestCase;

class LittleChildrenDiscountMiddlewareTest extends TestCase
{
    public function testDifferenceSuccess(): void
    {
        $middleware = new LittleChildrenDiscountMiddleware(0);

        $price = 1000;

        $input = new CalculatePriceActionInput(
            $price,
            4,
            new \DateTime(),
            new \DateTime()
        );

        $result = $middleware->action(
            $input,
            fn(CalculatePriceActionInput $input) => new CalculatePriceActionOutput($input->getPrice())
        );

        $this->assertNotEquals($price, $result->getPrice());
    }

    public function testDifferenceFailedTest(): void
    {
        $middleware = new LittleChildrenDiscountMiddleware(0);

        $price = 1000;

        $input = new CalculatePriceActionInput(
            $price,
            1,
            new \DateTime(),
            new \DateTime()
        );

        $result = $middleware->action(
            $input,
            fn(CalculatePriceActionInput $input) => new CalculatePriceActionOutput($input->getPrice())
        );

        $this->assertEquals($price, $result->getPrice());
    }
}
