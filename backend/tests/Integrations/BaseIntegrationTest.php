<?php

namespace App\Tests\Integrations;

use App\Repository\UserRepository;
use App\UseCases\CommandBus;
use App\UseCases\QueryBus;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Uid\Uuid;

#[DoesNotPerformAssertions]
abstract class BaseIntegrationTest extends KernelTestCase
{
    protected ContainerInterface $container;
    protected EntityManagerInterface $entityManager;
    protected QueryBus $queryBus;
    protected CommandBus $commandBus;

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->container = self::getContainer();
        $this->commandBus = $this->container->get(CommandBus::class);
        $this->queryBus = $this->container->get(QueryBus::class);
        $this->entityManager = $this->container->get(EntityManagerInterface::class);
    }

    protected function getService(string $serviceId): object
    {
        return $this->container->get($serviceId);
    }

    protected function as(Uuid $id): void
    {
        $user = $this->container->get(UserRepository::class)->findOneBy(['id' => $id]);

        $token = new UsernamePasswordToken($user, 'api', $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
    }

    protected function dispatchCommand(object $command): mixed
    {
        return $this->commandBus->execute($command);
    }

    protected function dispatchQuery(object $query): mixed
    {
        return $this->queryBus->query($query);
    }

    protected function persistAndFlush(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
    }

    protected function refresh(object $entity): void
    {
        $this->entityManager->refresh($entity);
    }

    protected function clear(): void
    {
        $this->entityManager->clear();
    }
}
