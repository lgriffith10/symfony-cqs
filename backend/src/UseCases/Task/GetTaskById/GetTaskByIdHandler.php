<?php

namespace App\UseCases\Task\GetTaskById;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\UseCases\Task\GetTaskById\Dtos\TaskById;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetTaskByIdHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * @return ApiResponse<GetTaskByIdResponse>
     * */
    public function __invoke(GetTaskByIdQuery $query): ApiResponse
    {
        $qb = $this->em->createQueryBuilder();

        /* @var TaskById $result */
        $result = $qb->select(
            \sprintf(
                'NEW %s(t.id, t.Name, t.Description, t.State, t.ExpectedAt, cu.email, t.createdAt, uu.email, t.updatedAt, du.email, t.deletedAt)',
                TaskById::class
            )
        )
            ->from(Task::class, 't')
            ->where('t.id = :id')
            ->innerJoin('t.createdBy', 'cu')
            ->leftJoin('t.updatedBy', 'uu')
            ->leftJoin('t.deletedBy', 'du')
            ->setParameter('id', $query->id)
            ->getQuery()
            ->getSingleResult();

        return ApiResponse::success(new GetTaskByIdResponse($result));
    }
}
