<?php

namespace App\UseCases\Task\GetTaskById\Dtos;

use App\Enum\TaskState;
use Symfony\Component\Uid\Uuid;

class TaskById
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $description,
        public TaskState $state,
        public \DateTimeImmutable $expectedAt,
        public string $createdBy,
        public ?\DateTimeImmutable $createdAt,
        public ?string $updatedBy,
        public ?\DateTimeImmutable $updatedAt,
        public ?string $deletedBy,
        public ?\DateTimeImmutable $deletedAt
    ) {
    }
}
