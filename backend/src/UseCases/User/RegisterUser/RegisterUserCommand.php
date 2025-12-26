<?php

namespace App\UseCases\User\RegisterUser;

readonly final class RegisterUserCommand
{
    function __construct(
        public string $email,
        public string $password
    )
    {
    }
}
