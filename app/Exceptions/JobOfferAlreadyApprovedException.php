<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class JobOfferAlreadyApprovedException extends  Exception
{
    public function __construct(string $message = "Job offer has already been approved.", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
