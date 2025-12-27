<?php

namespace App\Tests\Builders\Task;

use App\Tests\Traits\WithFaker;
use App\UseCases\Task\CreateTask\CreateTaskCommand;

final class CreateTaskCommandBuilder
{
    use WithFaker;

    private function __construct(private CreateTaskCommand $command)
    {
    }

    public static function create(): self
    {
        return new self(
            new CreateTaskCommand(
                name: self::faker()->name(),
                description: self::faker()->text(),
                expectedAt: \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            )
        );
    }

    public function withName(string $name): self
    {
        $this->command->name = $name;

        return $this;
    }

    public function get(): CreateTaskCommand
    {
        return $this->command;
    }
}
