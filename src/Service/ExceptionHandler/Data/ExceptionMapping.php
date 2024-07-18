<?php

namespace App\Service\ExceptionHandler\Data;

class ExceptionMapping
{
    private int $code;

    private bool $loggable;

    private bool $hidden;

    public function __construct(int $code, bool $loggable, bool $hidden)
    {
        $this->code = $code;
        $this->loggable = $loggable;
        $this->hidden = $hidden;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

}
