<?php

declare(strict_types=1);

namespace App\Contracts;

interface JobStatusServiceInterface
{
    const APPROVE = 'approve';
    const SPAM = 'spam';
    /**
     * @param  string  $id
     * @param  string  $status
     */
    public function jobStatus(string $id, string $status): void;
}
