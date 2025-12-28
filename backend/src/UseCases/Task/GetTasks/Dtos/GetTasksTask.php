<?php

namespace App\UseCases\Task\GetTasks\Dtos;

use App\Enum\TaskState;
use Symfony\Component\Uid\Uuid;

final readonly class GetTasksTask
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public TaskState $state,
        public \DateTimeImmutable $expectedAt,
    ) {
    }
}