<?php

namespace App\UseCases\Task\GetTasks;

use App\Dtos\ApiResponse;
use App\Entity\Task;
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
    ) {
    }

    public function __invoke(GetTasksQuery $query): ApiResponse
    {
        $qb = $this->em->createQueryBuilder();

        $result = $qb->select(
            \sprintf(
                'NEW %s(t.id, t.Name, t.State, t.ExpectedAt)',
                GetTasksTask::class
            )
        )
            ->from(Task::class, 't')
            ->where('t.createdBy = :userId')
            ->orderBy('t.createdAt', 'DESC')
            ->addOrderBy('t.ExpectedAt', 'ASC')
            ->setParameter('userId', $this->security->getUser()->getUserIdentifier())
            ->getQuery()
            ->getArrayResult();

        return ApiResponse::success(new GetTasksResponse($result));
    }
}
