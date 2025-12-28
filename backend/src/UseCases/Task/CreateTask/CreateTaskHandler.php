<?php

namespace App\UseCases\Task\CreateTask;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class CreateTaskHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @return ApiResponse<CreateTaskResponse>
     */
    public function __invoke(CreateTaskCommand $command): ApiResponse
    {
        $task = new Task();

        $user = $this->userRepository->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()]);

        $task->setId(Uuid::v7());
        $task->setName($command->name);
        $task->setDescription($command->description);
        $task->setExpectedAt($command->expectedAt);
        $task->setCreatedAt(new \DateTimeImmutable());
        $task->setCreatedBy($user);

        $this->em->persist($task);
        $this->em->flush();

        return ApiResponse::created(new CreateTaskResponse(id: $task->getId()));
    }
}
