<?php

declare(strict_types=1);

namespace App\DTO;

class LoginDTO extends Base
{
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;
}
