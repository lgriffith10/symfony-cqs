<?php

namespace App\Controller;

use App\Dtos\ApiResponse;
use App\UseCases\CommandBus;
use App\UseCases\Task\CreateTask\CreateTaskCommand;
use App\UseCases\Task\CreateTask\CreateTaskResponse;
use App\UseCases\Task\DeleteTask\DeleteTaskCommand;
use App\UseCases\Task\EditTask\EditTaskCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tasks')]
final class TaskController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(): Response
    {
        return new JsonResponse();
    }

    #[Route('/', name: 'app_task_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateTaskCommand $command): Response
    {
        /* @var ApiResponse<CreateTaskResponse> $result */
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result, $result->statusCode);
    }

    #[Route('/{id}', name: 'app_task_update', methods: ['PUT'])]
    public function edit(#[MapRequestPayload] EditTaskCommand $command): Response
    {
        /* @var ApiResponse $result */
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result, $result->statusCode);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(#[MapRequestPayload] DeleteTaskCommand $command): Response
    {
        /* @var ApiResponse $result */
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result, $result->statusCode);
    }
}
