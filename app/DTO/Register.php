<?php

declare(strict_types=1);

namespace App\DTO;

class Register extends Base
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $role_id;
}
