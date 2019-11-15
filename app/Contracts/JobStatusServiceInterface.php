<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface JobStatusServiceInterface
{
    /**
     * @param  string  $id
     * @param  string  $status
     * @throws ModelNotFoundException
     * @throws Throwable
     */
    public function jobStatus(string $id, string $status): void;
}
