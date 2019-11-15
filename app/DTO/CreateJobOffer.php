<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\Carbon;

/**
 * Class CreateJobOffer
 * @package App\DTO
 * @property string $title
 * @property string $description
 * @property string $email
 * @property string $validUntil
 */
class CreateJobOffer extends Base
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
     * @var Carbon
     */
    protected $validUntil;
}
