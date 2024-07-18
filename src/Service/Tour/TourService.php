<?php

namespace App\Service\Tour;

use App\Middleware\CalculatePrice\CalculatePriceInterface;
use App\Middleware\CalculatePrice\CalculatePricePipeline;
use App\Middleware\CalculatePrice\Data\CalculatePriceActionInput;
use App\Service\Tour\Data\CalculatePriceInput;
use App\Service\Tour\Data\CalculatePriceOutput;
use Psr\Log\LoggerInterface;

class TourService implements TourServiceInterface
{

    /**
     * @param array{class: class-string<CalculatePriceInterface>, priority: int} $calculateMiddlewares
     */
    public function __construct(
        private readonly array $calculateMiddlewares
    )
    {}

    public function calculatePrice(CalculatePriceInput $input): CalculatePriceOutput
    {
        $middlewares = array_map(
            fn (array $calculatePrice) => [
                    'middleware' => new $calculatePrice['class']($input->getBasePrice()),
                    'priority' => $calculatePrice['priority']
                ],
            $this->calculateMiddlewares
        );

        $clientAge = $input->getDateStart()->diff($input->getDateBirthday())->y;

        $pipeline = new CalculatePricePipeline($middlewares);
        $result = $pipeline->action(new CalculatePriceActionInput(
            $input->getBasePrice(),
            $clientAge,
            $input->getDateStart(),
            $input->getDatePayment(),
        ));

        return new CalculatePriceOutput($result->getPrice());
    }
}
