<?php

namespace App\UseCases\User\RegisterUser;

use Symfony\Component\Uid\Uuid;

readonly final class RegisterUserResponse
{
    function __construct(
        public Uuid $id
    )
    {

    }
}