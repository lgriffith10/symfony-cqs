<?php

namespace App\UseCases\User\Me;

class MeResponse
{
    public function __construct(
        public string $email
    ) {
    }
}
