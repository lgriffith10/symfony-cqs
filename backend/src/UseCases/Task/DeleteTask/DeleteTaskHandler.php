<?php

namespace App\UseCases\Task\DeleteTask;

use App\Dtos\ApiResponse;
use App\Enum\TaskState;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\UseCases\Task\TaskAuthorizationChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteTaskHandler
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
            return ApiResponse::notFound("GetTasksTask with id {$command->id} not found.");
        }

        $canDelete = $this->authorizationChecker->canViewAndEdit($command->id);

        if (! $canDelete) {
            return ApiResponse::forbidden();
        }

        // Handler

        $currentUser = $this->userRepository->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()]);
        $task->setDeletedAt(new \DateTimeImmutable());
        $task->setDeletedBy($currentUser);
        $task->setState(TaskState::Deleted);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return ApiResponse::noContent();
    }
}
