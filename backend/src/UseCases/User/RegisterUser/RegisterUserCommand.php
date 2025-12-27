<?php

namespace App\UseCases\User\RegisterUser;

use Symfony\Component\Validator\Constraints as Assert;

readonly final class RegisterUserCommand
{
    function __construct(
        public string $email,
        public string $password
    )
    {
    }
}
