<?php

declare(strict_types=1);

namespace Integrations\Auth;

use App\Dtos\ApiResponse;
use App\Repository\UserRepository;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\User\RegisterUser\RegisterUserCommand;

class RegisterUserTest extends BaseIntegrationTest
{
    protected UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
    }

    public function testRegisterUserShouldSucceed(): void
    {
        // Arrange
        $command = new RegisterUserCommand(email: 'integration@test.com', password: 'password');

        // Act
        /* @var ApiResponse<RegisterUserCommand> $result */
        $result = $this->dispatchCommand($command);

        // Assert;
        $this->assertTrue($result->success);

        $user = $this->userRepository->findOneBy(['email' => $command->email]);

        $this->assertNotNull($user);
        $this->assertEquals($command->email, $user->getEmail());
        $this->assertEquals($result->data->id, $user->getId());
    }

    public function testRegisterUserWithAlreadyTakenEmailShouldFail(): void
    {
        // Arrange
        $command = new RegisterUserCommand(email: 'test@test.com', password: 'password');

        // Act
        /* @var ApiResponse<RegisterUserCommand> $result */
        $result = $this->dispatchCommand($command);

        // Assert
        $this->assertFalse($result->success);
        $this->assertNotNull($result->error);

        $this->assertEquals('User already exists.', $result->error['message']);
    }
}
