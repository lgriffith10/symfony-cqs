<?php

namespace Integrations\Task;

use App\Dtos\ApiResponse;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskState;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\Factory\TaskFactory;
use App\Tests\Integrations\BaseIntegrationTestCase;
use App\UseCases\Task\DeleteTask\DeleteTaskCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class DeleteTaskTest extends BaseIntegrationTestCase
{
    private User $user;
    private Task $task;

    private UserRepository $userRepository;
    private TaskRepository $taskRepository;

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

    public function testShouldSucceed(): void
    {
        // Arrange
        $command = new DeleteTaskCommand($this->task->getId());

        // Act
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertTrue($result->success);

        $task = $this->taskRepository->find($this->task->getId());
        $this->assertInstanceOf(Task::class, $task);
        $this->assertNotNull($task->getDeletedAt());
        $this->assertEquals($this->user->getId(), $task->getDeletedBy()->getId());
        $this->assertTrue($task->isDeleted());
        $this->assertEquals($this->task->getState(), TaskState::Deleted);
    }

    public function testWithNotFoundTaskShouldFail(): void
    {
        // Arrange
        $command = new DeleteTaskCommand(Uuid::v7());

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertFalse($result->success);
        $this->assertEquals(404, $result->statusCode);
        $this->assertEquals("GetTasksTask with id {$command->id} not found.", $result->error['message']);
    }

    public function testWithInsufficientPermissionsShouldFail(): void
    {
        // Arrange
        $command = new DeleteTaskCommand($this->task->getId());

        $userId = $this->userRepository->findOneBy(['email' => 'john@doe.com'])->getId();
        $this->as($userId);

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertFalse($result->success);
        $this->assertEquals(403, $result->statusCode);
        $this->assertEquals('Forbidden.', $result->error['message']);
    }
}
