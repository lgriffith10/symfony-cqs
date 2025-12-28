<?php

namespace App\UseCases\Task\GetTaskById;

use App\UseCases\Task\GetTaskById\Dtos\TaskById;

final readonly class GetTaskByIdResponse
{
    public function __construct(public readonly TaskById $task)
    {
    }
}
