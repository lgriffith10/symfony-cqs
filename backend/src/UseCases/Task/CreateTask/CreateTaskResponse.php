<?php

namespace App\UseCases\Task\CreateTask;

use Symfony\Component\Uid\Uuid;

class CreateTaskResponse
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}
