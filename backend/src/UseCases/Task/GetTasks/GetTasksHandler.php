<?php

namespace App\UseCases\Task\GetTasks;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Repository\UserRepository;
use App\UseCases\Task\GetTasks\Dtos\GetTasksTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetTasksHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(GetTasksQuery $query): ApiResponse
    {
        $userId = $this->userRepository->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()])->getId();

        $qb = $this->em->createQueryBuilder();

        $result = $qb
            ->select('t.id', 't.Name', 't.State', 't.ExpectedAt')
            ->from(Task::class, 't')
            ->where('t.createdBy = :userId')
            ->orderBy('t.createdAt', 'DESC')
            ->addOrderBy('t.ExpectedAt', 'ASC')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getArrayResult();

        $dto = array_map(fn (array $row) => GetTasksTask::fromArray($row), $result);

        return ApiResponse::success(new GetTasksResponse($dto));
    }
}
