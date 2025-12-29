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

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] instanceof Uuid
                ? $data['id']
                : Uuid::fromString($data['id']),
            name: $data['Name'],
            state: $data['State'] instanceof TaskState
                ? $data['State']
                : TaskState::from($data['state']),
            expectedAt: $data['ExpectedAt'] instanceof \DateTimeImmutable
                ? $data['ExpectedAt']
                : new \DateTimeImmutable($data['expectedAt'])
        );
    }
}
