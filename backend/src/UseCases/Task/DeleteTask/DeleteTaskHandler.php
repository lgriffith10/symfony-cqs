<?php

namespace App\UseCases\Task\DeleteTask;

use App\Dtos\ApiResponse;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\UseCases\Task\TaskAuthorizationChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteTaskHandler
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly Security $security,
        private readonly TaskAuthorizationChecker $authorizationChecker,
    ) {
    }

    public function __invoke(DeleteTaskCommand $command): ApiResponse
    {
        // ACL

        $task = $this->taskRepository->findOneBy(['id' => $command->id]);

        if (null === $task) {
            return ApiResponse::notFound("Task with id {$command->id} not found.");
        }

        $canDelete = $this->authorizationChecker->canEdit($command->id);

        if (! $canDelete) {
            return ApiResponse::forbidden();
        }

        // Handler

        $currentUser = $this->userRepository->findOneBy(['id' => $this->security->getUser()->getUserIdentifier()]);
        $task->setDeletedAt(new \DateTimeImmutable());
        $task->setDeletedBy($currentUser);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return ApiResponse::noContent();
    }
}
