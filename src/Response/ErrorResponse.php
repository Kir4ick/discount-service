<?php

namespace App\Response;

class ErrorResponse
{
    private string $errorMessage;

    private mixed $details;

    public function __construct(string $errorMessage, mixed $details = null)
    {
        $this->errorMessage = $errorMessage;
        $this->details = $details;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getDetails(): mixed
    {
        return $this->details;
    }

}
