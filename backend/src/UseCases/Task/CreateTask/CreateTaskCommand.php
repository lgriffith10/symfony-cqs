<?php

namespace App\UseCases\Task\CreateTask;

class CreateTaskCommand
{
    public function __construct(
        public string $name,
        public string $description,
        public \DateTimeImmutable $expectedAt
    ) {
    }
}
