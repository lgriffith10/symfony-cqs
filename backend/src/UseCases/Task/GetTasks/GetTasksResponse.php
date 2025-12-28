<?php

namespace App\UseCases\Task\GetTasks;

use App\UseCases\Task\GetTasks\Dtos\GetTasksTask;

final readonly class GetTasksResponse
{
    public function __construct(
        /* @var array<GetTasksTask> $tasks */
        public array $tasks
    ) {
    }
}
