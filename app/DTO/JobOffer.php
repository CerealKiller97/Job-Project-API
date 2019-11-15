<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\Carbon;

class JobOffer
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $email;
    /**
     * @var int
     */
    public $isPublished;
    /**
     * @var int
     */
    public $isSpan;
    /**
     * @var Carbon
     */
    public $validUntil;
}
