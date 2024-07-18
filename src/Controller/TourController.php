<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Request\CalculatePriceRequest;
use App\Response\CalculatePriceResponse;
use App\Service\Tour\Data\CalculatePriceInput;
use App\Service\Tour\TourServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TourController extends AbstractController
{

    public function __construct(
        private readonly TourServiceInterface $tourService
    )
    {}

    #[Route('/api/tour/calculate', methods: Request::METHOD_POST)]
    public function calculatePrice(#[RequestBody] CalculatePriceRequest $priceRequest): JsonResponse
    {
        $result = $this->tourService->calculatePrice(
            new CalculatePriceInput(
                $priceRequest->getBasePrice(),
                $priceRequest->getDateBirthday(),
                $priceRequest->getDateStart(),
                $priceRequest->getDatePayment()
            )
        );

        return $this->json(
            (new CalculatePriceResponse())->setPrice($result->getPrice())
        );
    }

}
