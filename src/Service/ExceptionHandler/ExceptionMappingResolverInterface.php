<?php

namespace App\Service\ExceptionHandler;

use App\Service\ExceptionHandler\Data\ExceptionMapping;
use Throwable;

interface ExceptionMappingResolverInterface
{

    public function resolve(Throwable $throwable): ?ExceptionMapping;

    public static function fromCode(int $code): ExceptionMapping;

}
