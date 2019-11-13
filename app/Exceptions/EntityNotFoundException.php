<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class EntityNotFoundException extends Exception
{
    public function __construct(string $message = "Resource", int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message . " not found.", $code, $previous);
    }
}
