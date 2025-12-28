<?php

namespace App\UseCases\Task;

use App\Entity\Task;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;

final readonly class TaskAuthorizationChecker
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $em,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function canViewAndEdit(Uuid $taskId): bool
    {
        $userId = $this->userRepository->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()])->getId();
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
