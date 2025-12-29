<?php

namespace Integrations\Task;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Factory\TaskFactory;
use App\Tests\Integrations\BaseIntegrationTestCase;
use App\UseCases\Task\GetTasks\GetTasksQuery;
use App\UseCases\Task\GetTasks\GetTasksResponse;
use Doctrine\ORM\EntityManagerInterface;

final class GetTasksTest extends BaseIntegrationTestCase
{
    private User $user;
    private UserRepository $userRepository;

    private Task $task;
    private Task $task2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
        $this->user = $this->userRepository->findOneBy(['email' => 'test@test.com']);

        $this->as($this->user->getId());

        $this->task = TaskFactory::createOne(['createdBy' => $this->user, 'createdAt' => new \DateTimeImmutable('2000-01-01')]);
        $this->task2 = TaskFactory::createOne(['createdBy' => $this->user, 'createdAt' => new \DateTimeImmutable()]);

        /* @var EntityManagerInterface $em */
        $em = $this->getService(EntityManagerInterface::class);

        $em->persist($this->task);
        $em->persist($this->task2);
        $em->flush();
    }

    public function testGetTasksShouldSucceed(): void
    {
        // Arrange
        $query = new GetTasksQuery();

        // Act
        /* @var ApiResponse<GetTasksResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);
        $this->assertCount(2, $result->data->tasks);

        $task1 = $result->data->tasks[0];
        $task2 = $result->data->tasks[1];

        $this->assertEquals($task1->id, $this->task2->getId());
        $this->assertEquals($task2->id, $this->task->getId());

        $this->assertEquals($task1->name, $this->task2->getName());
        $this->assertEquals($task1->state, $this->task2->getState());
        $this->assertEquals($task1->expectedAt, $this->task2->getExpectedAt());

        $this->assertEquals($task2->name, $this->task->getName());
        $this->assertEquals($task2->state, $this->task->getState());
        $this->assertEquals($task2->expectedAt, $this->task->getExpectedAt());
    }

    public function testGetTasksWithOtherUserShouldSucceed(): void
    {
        // Arrange
        $query = new GetTasksQuery();
        $userId = $this->userRepository->findOneBy(['email' => 'john@doe.com'])->getId();
        $this->as($userId);

        // Act
        /* @var ApiResponse<GetTasksResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);

        $this->assertCount(0, $result->data->tasks);
    }
}
