<?php

namespace App\Middleware\CalculatePrice;

use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionOutput;
use App\Service\Tour\Data\CalculatePriceInput;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

final class CalculatePricePipeline
{

    /**
     * @param CalculatePriceInterface[] $calculateMiddlewares
     */
    public function __construct(
        private array $calculateMiddlewares
    )
    {
        usort($this->calculateMiddlewares, function (array $a, array $b) {
            if ($a['priority'] == $b['priority']) {
                return 0;
            }

            return ($a['priority'] < $b['priority']) ? -1 : 1;
        });
    }

    public function action(CalculatePriceActionInput $input): CalculatePriceActionOutput
    {
        $middleware = array_shift($this->calculateMiddlewares);
        $middleware = $middleware['middleware'] ?? null;

        if ($middleware != null) {
            return $middleware->action($input, [$this, 'action']);
        }

        return new CalculatePriceActionOutput($input->getPrice());
    }
}
