<?php

namespace App\UseCases\Task\GetTaskById;

use Symfony\Component\Uid\Uuid;

final readonly class GetTaskByIdQuery
{
    public function __construct(public Uuid $id)
    {
    }
}
