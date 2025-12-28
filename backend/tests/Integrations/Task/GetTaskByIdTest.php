<?php

namespace Integrations\Task;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\Builders\Task\EditTaskCommandBuilder;
use App\Tests\Factory\TaskFactory;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\Task\GetTaskById\GetTaskByIdQuery;
use App\UseCases\Task\GetTaskById\GetTaskByIdResponse;
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
        /* @var ApiResponse<GetTaskByIdResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);
        $this->assertNotNull($result->data);

        $task = $result->data->task;

        $this->assertNotNull($task);
        $this->assertEquals($this->task->getId(), $task->id);
        $this->assertEquals($this->task->getName(), $task->name);
        $this->assertEquals($this->task->getDescription(), $task->description);
        $this->assertEquals($this->task->getState(), $task->state);
        $this->assertEquals($this->task->getExpectedAt(), $task->expectedAt);
        $this->assertEquals($this->task->getCreatedBy()->getEmail(), $task->createdBy);
        $this->assertEquals($this->task->getUpdatedBy()?->getEmail(), $task->updatedBy);
        $this->assertEquals($this->task->getDeletedBy()?->getEmail(), $task->deletedBy);
        $this->assertEqualsWithDelta($this->task->getCreatedAt()->getTimestamp(), $task->createdAt->getTimestamp(), 1);
        $this->assertEqualsWithDelta($this->task->getUpdatedAt()?->getTimestamp(), $task->updatedAt?->getTimestamp(), 1);
        $this->assertEqualsWithDelta($this->task->getDeletedAt()?->getTimestamp(), $task->deletedAt?->getTimestamp(), 1);
    }

    public function testGetTaskByIdWithUpdatedShouldSucceed(): void
    {
        // Arrange
        $query = new GetTaskByIdQuery($this->task->getId());
        $editQuery = EditTaskCommandBuilder::create()->withId($this->task->getId())->get();
        $this->dispatchQuery($editQuery);

        // Act
        /* @var ApiResponse<GetTaskByIdResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);
        $this->assertNotNull($result->data);

        $task = $result->data->task;

        $this->assertNotNull($task);
        $this->assertEquals($this->task->getUpdatedBy()->getEmail(), $task->updatedBy);
        $this->assertEqualsWithDelta($this->task->getUpdatedAt()->getTimestamp(), $task->updatedAt->getTimestamp(), 1);
    }
}
