<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class AccountNotVerifiedException extends Exception
{
    public function __construct(string $message = "Account is not verified.", int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
