<?php

namespace App\Listener;

use App\Entity\Interface\AuditableInterface;
use App\Entity\Trait\AuditTrait;
use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: Events::prePersist, method: 'prePersist')]
#[AsEventListener(event: Events::preUpdate, method: 'preUpdate')]
final readonly class AuditListener
{
    public function __construct(private readonly Security $security)
    {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof AuditableInterface) {
            if ($this->hasAuditTrait($entity)) {
                $entity->setCreatedAt(new \DateTimeImmutable());

                $user = $this->security->getUser();
                if ($user instanceof User) {
                    $entity->setCreatedBy($user);
                }
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof AuditableInterface) {
            if ($this->hasAuditTrait($entity)) {
                $entity->setUpdatedAt(new \DateTimeImmutable());

                $user = $this->security->getUser();
                if ($user instanceof User) {
                    $entity->setUpdatedBy($user);
                }
            }
        }
    }

    private function hasAuditTrait(object $entity): bool
    {
        return \in_array(AuditTrait::class, class_uses($entity), true);
    }
}
