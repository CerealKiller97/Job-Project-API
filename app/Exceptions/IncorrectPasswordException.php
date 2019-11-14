<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class IncorrectPasswordException extends Exception
{
    public function __construct($message = "Wrong password.", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
