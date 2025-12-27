<?php

namespace App\Integrations\Task;

use App\Dtos\ApiResponse;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\Builders\Task\CreateTaskCommandBuilder;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\Task\CreateTask\CreateTaskResponse;

class CreateTaskTest extends BaseIntegrationTest
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $userRepository = $this->getService(UserRepository::class);
        $this->user = $userRepository->findOneBy(['email' => 'test@test.com']);
    }

    public function testShouldSucceed(): void
    {
        // Arrange
        $this->as($this->user->getId());
        $request = CreateTaskCommandBuilder::create()->get();

        // Act
        /* @var ApiResponse<CreateTaskResponse> $result */
        $result = $this->dispatchCommand($request);

        // Assert
        $this->assertTrue($result->success);

        $taskRepository = $this->getService(TaskRepository::class);
        $task = $taskRepository->findOneBy(['id' => $result->data->id]);

        $this->assertNotNull($task);
        $this->assertEquals($request->name, $task->getName());
        $this->assertEquals($request->description, $task->getDescription());
        $this->assertEquals($request->expectedAt, $task->getExpectedAt());
        $this->assertEquals($this->user->getId(), $task->getCreatedBy()->getId());
    }
}
