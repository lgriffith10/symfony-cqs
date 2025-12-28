<?php

namespace App\UseCases\Task\EditTask;

use App\Dtos\ApiResponse;
use App\Repository\TaskRepository;
use App\UseCases\Task\TaskAuthorizationChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class EditTaskHandler
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly EntityManagerInterface $em,
        private readonly TaskAuthorizationChecker $taskAuthorizationChecker,
        private readonly Security $security,
    ) {
    }

    public function __invoke(EditTaskCommand $command): ApiResponse
    {
        // ACL

        $this->security->getUser();
        $task = $this->taskRepository->findOneBy(['id' => $command->id]);

        if (! $task) {
            return ApiResponse::notFound("GetTasksTask with id {$command->id} not found.");
        }

        $canEditTask = $this->taskAuthorizationChecker->canViewAndEdit($command->id);

        if (! $canEditTask) {
            return ApiResponse::forbidden();
        }

        // Handler

        $task->setName($command->name);
        $task->setDescription($command->description);
        $task->setExpectedAt($command->expectedAt);

        $task->setUpdatedAt(new \DateTimeImmutable());
        $task->setUpdatedBy($this->security->getUser());

        $this->em->persist($task);
        $this->em->flush();

        return ApiResponse::noContent();
    }
}
