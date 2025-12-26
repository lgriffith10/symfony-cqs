<?php

namespace App\UseCases\User\Me;

class MeResponse
{
    function __construct(
        public ?string $email
    )
    {
    }
}