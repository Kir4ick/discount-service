<?php

namespace App\Tests\Middleware;

use App\Middleware\CalculatePrice\Children\LittleChildrenDiscountMiddleware;
use App\Middleware\CalculatePrice\Children\MiddleChildrenDiscountMiddleware;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;
use PHPUnit\Framework\TestCase;

class MiddleChildrenDiscountMiddlewareTest extends TestCase
{
    public function testDifferenceSuccess(): void
    {
        $middleware = new MiddleChildrenDiscountMiddleware(0);

        $price = 1000;

        $input = new CalculatePriceActionInput(
            $price,
            9,
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
        $middleware = new MiddleChildrenDiscountMiddleware(0);

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
