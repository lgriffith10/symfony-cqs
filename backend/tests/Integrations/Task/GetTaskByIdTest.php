<?php

namespace Integrations\Task;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\Factory\TaskFactory;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\Task\GetTaskById\GetTaskByIdQuery;
use Doctrine\ORM\EntityManagerInterface;

final class GetTaskByIdTest extends BaseIntegrationTest
{
    private User $user;
    private Task $task;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = $this->getService(TaskRepository::class);

        $this->userRepository = $this->getService(UserRepository::class);
        $this->user = $this->userRepository->findOneBy(['email' => 'test@test.com']);

        $this->as($this->user->getId());

        $this->task = TaskFactory::createOne(['createdBy' => $this->user, 'createdAt' => new \DateTimeImmutable()]);

        /* @var EntityManagerInterface $userRepository */
        $em = $this->getService(EntityManagerInterface::class);

        $em->persist($this->task);
        $em->flush();
    }

    public function testGetTaskByIdShouldSucceed(): void
    {
        // Arrange
        $query = new GetTaskByIdQuery($this->task->getId());

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);
        $this->assertNotNull($result->data);

        //        TODO: finish tests
    }
}
