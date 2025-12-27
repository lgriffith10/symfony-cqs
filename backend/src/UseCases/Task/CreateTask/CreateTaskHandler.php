<?php

namespace App\UseCases\Task\CreateTask;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateTaskHandler
{
    public function __construct(
    ) {
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        throw new \Exception();
        // TODO: Implement __invoke() method.
    }
}
