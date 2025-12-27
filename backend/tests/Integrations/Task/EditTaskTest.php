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
use Doctrine\ORM\EntityManagerInterface;

final class EditTaskTest extends BaseIntegrationTest
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
        $command = EditTaskCommandBuilder::create()
            ->withId($this->task->getId())
            ->get();

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertTrue($result->success);

        $task = $this->taskRepository->find($this->task->getId());

        $this->assertNotNull($task);
        $this->assertEquals($command->id, $task->getId());
        $this->assertEquals($command->name, $task->getName());
        $this->assertEquals($command->description, $task->getDescription());
        $this->assertEquals($command->expectedAt, $task->getExpectedAt());
        $this->assertEquals($this->user->getId(), $task->getCreatedBy()->getId());
    }

    public function testWithNotFoundTaskShouldFail()
    {
        // Arrange
        $command = EditTaskCommandBuilder::create()
            ->get();

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertFalse($result->success);
        $this->assertEquals(404, $result->statusCode);
        $this->assertEquals("Task with id {$command->id} not found.", $result->error['message']);
    }

    public function testWithInsufficiantPermissionsShouldFail()
    {
        // Arrange
        $command = EditTaskCommandBuilder::create()
            ->withId($this->task->getId())
            ->get();

        $userId = $this->userRepository->findOneBy(['email' => 'john@doe.com'])->getId();

        $this->as($userId);

        // Act
        /* @var ApiResponse $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertFalse($result->success);
        $this->assertEquals(403, $result->statusCode);
    }
}
