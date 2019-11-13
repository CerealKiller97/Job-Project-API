<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class IncorrectPasswordException extends Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
