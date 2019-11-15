<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class Login
 * @package App\DTO
 * @property string $email
 * @property string $password
 */
class Login extends Base
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
