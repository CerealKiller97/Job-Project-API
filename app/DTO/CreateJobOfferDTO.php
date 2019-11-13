<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\Carbon;

class CreateJobOfferDTO extends Base
{
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $email;

    /**
     * @var bool
     */
    protected $isSpam;
    /**
     * @var
     */
    protected $isPublished;
    /**
     * @var Carbon
     */
    protected $valid_until;
}
