<?php

namespace App\Service\ExceptionHandler;

use App\Service\ExceptionHandler\Data\ExceptionMapping;
use Throwable;

class ExceptionMappingResolver implements ExceptionMappingResolverInterface
{

    private array $mappings;

    public function __construct(array $exceptions)
    {
        foreach ($exceptions as $class => $exception) {
            if (!isset($exception['code'])) {
                throw new \InvalidArgumentException('code is not be blank');
            }

            $this->mappings[$class] = new ExceptionMapping(
                $exception['code'],
                $exception['loggable'] ?? true,
                $exception['hidden'] ?? true,
            );
        }
    }

    public function resolve(Throwable $throwable): ?ExceptionMapping
    {
        foreach ($this->mappings as $class => $map) {
            if ($throwable::class !== $class && !is_subclass_of($throwable::class, $class)) {
                continue;
            }

            return $map;
        }

        return null;
    }

    public static function fromCode(int $code): ExceptionMapping
    {
        return new ExceptionMapping($code, true, true);
    }
}
