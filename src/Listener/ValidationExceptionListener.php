<?php

namespace App\Listener;

use App\Exception\ValidationException;
use App\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ValidationExceptionListener
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {}

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if (!($throwable instanceof ValidationException)) {
            return;
        }

        $errorList = [];
        foreach ($throwable->getConstraintViolationList() as $violation) {
            $errorList[$violation->getPropertyPath()] = $violation->getMessage();
        }

        $data = $this->serializer->serialize(
            new ErrorResponse($throwable->getMessage(), [
                'validation' => $errorList
            ]),
            JsonEncoder::FORMAT
        );

        $event->setResponse(
            new JsonResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY, json: true)
        );
    }
}
