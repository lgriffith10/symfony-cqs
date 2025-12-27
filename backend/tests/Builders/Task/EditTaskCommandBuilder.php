<?php

namespace App\Tests\Builders\Task;

use App\Tests\Traits\WithFaker;
use App\UseCases\Task\EditTask\EditTaskCommand;
use Symfony\Component\Uid\Uuid;

final class EditTaskCommandBuilder
{
    use WithFaker;

    private function __construct(
        private EditTaskCommand $command
    ) {
    }

    public static function create(): self
    {
        return new self(new EditTaskCommand(
            id: Uuid::v7(),
            name: self::faker()->word(),
            description: self::faker()->text(),
            expectedAt: new \DateTimeImmutable(),
        ));
    }

    public function withId(Uuid $id): self
    {
        $this->command->id = $id;

        return $this;
    }

    public function get(): EditTaskCommand
    {
        return $this->command;
    }
}
