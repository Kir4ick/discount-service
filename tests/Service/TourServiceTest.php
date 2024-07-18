<?php

namespace App\Tests\Service;

use App\Service\Tour\Data\CalculatePriceInput;
use App\Service\Tour\TourService;
use PHPUnit\Framework\TestCase;

class TourServiceTest extends TestCase
{

    public function testCalculatePrice(): void
    {
        $middlewares = [
            ['class' => 'App\Middleware\CalculatePrice\Children\LittleChildrenDiscountMiddleware', 'priority' => 1],
            ['class' => 'App\Middleware\CalculatePrice\Children\MiddleChildrenDiscountMiddleware', 'priority' => 2],
            ['class' => 'App\Middleware\CalculatePrice\Children\OldChildrenDiscountMiddleware', 'priority' => 3],
            ['class' => 'App\Middleware\CalculatePrice\Reservasion\SecondReservasionGroupMiddleware', 'priority' => 4],
            ['class' => 'App\Middleware\CalculatePrice\Reservasion\FirstReservasionGroupMiddleware', 'priority' => 5],
            ['class' => 'App\Middleware\CalculatePrice\Reservasion\ThirtyReservasionGroupMiddleware', 'priority' => 6],
        ];

        $testCases = [
            [
                'data' => [
                    'price' => 0,
                    'dateBirthday' => new \DateTime(),
                    'dateStart' => new \DateTime(),
                    'datePayment' => new \DateTime(),
                ],
                'middlewares' => [],
                'expectedPrice' => 0
            ],
            [
                'data' => [
                    'price' => 10000,
                    'dateBirthday' => new \DateTime('2021-02-03'),
                    'dateStart' => new \DateTime('2025-01-16'),
                    'datePayment' => new \DateTime('2024-01-01'),
                ],
                'middlewares' => $middlewares,
                'expectedPrice' => 1860
            ],
            [
                'data' => [
                    'price' => 100000,
                    'dateBirthday' => new \DateTime('2016-01-01'),
                    'dateStart' => new \DateTime('2024-01-01'),
                    'datePayment' => new \DateTime('2017-01-01'),
                ],
                'middlewares' => $middlewares,
                'expectedPrice' => 95500
            ],
            [
                'data' => [
                    'price' => 10000,
                    'dateBirthday' => new \DateTime('2009-01-01'),
                    'dateStart' => new \DateTime('2024-01-01'),
                    'datePayment' => new \DateTime('2024-01-01'),
                ],
                'middlewares' => $middlewares,
                'expectedPrice' => 9000
            ],
        ];

        foreach ($testCases as $testCase) {
            $input = new CalculatePriceInput(
                $testCase['data']['price'],
                $testCase['data']['dateBirthday'],
                $testCase['data']['dateStart'],
                $testCase['data']['datePayment'],
            );

            $tourService = new TourService($testCase['middlewares']);
            $result = $tourService->calculatePrice($input);

            $this->assertEquals($testCase['expectedPrice'], $result->getPrice());
        }
    }

}
