<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class JobOfferIsAlreadySpamException extends Exception
{
    public function __construct(string $message = "Job offer is already marked as spam.", int $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
