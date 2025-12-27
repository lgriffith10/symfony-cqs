<?php

namespace App\UseCases\Task\DeleteTask;

use Symfony\Component\Uid\Uuid;

final readonly class DeleteTaskCommand
{
    public function __construct(public Uuid $id)
    {
    }
}
