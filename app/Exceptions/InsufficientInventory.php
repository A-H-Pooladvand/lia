<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InsufficientInventory extends Exception
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return apiResponse()->unprocessableEntity($this->message);
    }
}
