<?php

namespace App\UseCases\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

final readonly class TaskAuthorizationChecker
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $em
    ) {
    }

    public function canEdit(Uuid $taskId): bool
    {
        $userId = $this->security->getUser()->getUserIdentifier();
        $qb = $this->em->createQueryBuilder();

        $result = $qb->select('t')
            ->from(Task::class, 't')
            ->where('t.id = :taskId')
            ->setParameter('taskId', $taskId)
            ->andWhere('t.createdBy = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();

        return null !== $result;
    }
}
