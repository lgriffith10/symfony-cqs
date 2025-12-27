<?php

namespace App\UseCases\Task\EditTask;

use Symfony\Component\Uid\Uuid;

final class EditTaskCommand
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $description,
        public \DateTimeImmutable $expectedAt
    ) {
    }
}
