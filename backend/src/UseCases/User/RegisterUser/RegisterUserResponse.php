<?php

namespace App\UseCases\User\RegisterUser;

use Symfony\Component\Uid\Uuid;

final readonly class RegisterUserResponse
{
    public function __construct(
        public Uuid $id
    ) {
    }
}
