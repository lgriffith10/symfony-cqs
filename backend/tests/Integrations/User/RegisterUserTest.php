<?php

declare(strict_types=1);

namespace App\Tests\Integrations\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\User\RegisterUser\RegisterUserCommand;
use Symfony\Component\Uid\Uuid;

class RegisterUserTest extends BaseIntegrationTest
{
    protected UserRepository $userRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
    }

    public function testRegisterUser_ShouldSucceed(): void {
        // Arrange
        $command = new RegisterUserCommand(email: 'integration@test.com', password: 'password');

        // Act
        $result = $this->dispatchCommand($command);

        // Assert;
        $this->assertNotNull($result->id);

        $user = $this->userRepository->findOneBy(['email' => $command->email]);

        $this->assertNotNull($user);
        $this->assertEquals($command->email, $user->getEmail());
        $this->assertEquals($result->id, $user->getId());
    }

    public function testRegisterUser_WithAlreadyTakenEmail_ShouldFail(): void {
        // Arrange
        $command = new RegisterUserCommand(email: 'test@test.com', password: 'password');

        // Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email already in use.');


        // Act
        $this->dispatchCommand($command);
    }
}
