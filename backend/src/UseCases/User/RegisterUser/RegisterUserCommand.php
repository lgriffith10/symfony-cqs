<?php

namespace App\UseCases\User\RegisterUser;

final readonly class RegisterUserCommand
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
