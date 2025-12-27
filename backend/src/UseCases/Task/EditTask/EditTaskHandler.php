<?php

namespace App\UseCases\Task\EditTask;

use App\Dtos\ApiResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class EditTaskHandler
{
    public function __construct()
    {
    }

    public function __invoke(EditTaskCommand $command): ApiResponse
    {
        return ApiResponse::noContent();
    }
}
