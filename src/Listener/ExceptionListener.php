<?php

namespace App\Listener;

use App\Response\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMappingResolverInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ExceptionListener
{
    public function __construct(
        private readonly ExceptionMappingResolverInterface $exceptionMappingResolver,
        private readonly SerializerInterface $serializer,
        private readonly LoggerInterface $logger
    )
    {}

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        $exceptionModel = $this->exceptionMappingResolver->resolve($throwable);
        if ($exceptionModel === null) {
            $exceptionModel = $this->exceptionMappingResolver::fromCode(
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $message = $exceptionModel->isHidden() ?
            Response::$statusTexts[$exceptionModel->getCode()] :
            $throwable->getMessage();

        if ($exceptionModel->isLoggable()) {
            $this->log($throwable);
        }

        $data = $this->serializer->serialize(
            new ErrorResponse($message),
            JsonEncoder::FORMAT
        );

        $event->setResponse(new JsonResponse($data, $exceptionModel->getCode(), json: true));
    }

    private function log(Throwable $throwable): void
    {
        $logMessage = sprintf(
            '[api-error] ERROR: class: %s, message: %s, trace: %s',
            $throwable::class,
            $throwable->getMessage(),
            $throwable->getTraceAsString()
        );

        $this->logger->error($logMessage, [
            'trace' => $throwable->getTraceAsString(),
            'previous' => $throwable->getPrevious()?->getMessage()
        ]);
    }
}
