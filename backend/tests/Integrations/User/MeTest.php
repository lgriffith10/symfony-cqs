<?php

namespace App\Tests\Integrations\User;

use App\Repository\UserRepository;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\User\Me\MeQuery;
use App\Dtos\ApiResponse;
use App\UseCases\User\Me\MeResponse;

class MeTest extends BaseIntegrationTest
{
    private readonly UserRepository $userRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
    }

    public function testMe_ShouldSucceed(): void {
        // Arrange
        $query = new MeQuery();

        $user = $this->userRepository->findOneBy(['email' => 'test@test.com']);
        $this->as($user->getId());

        // Act
        /* @var ApiResponse<MeResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertTrue($result->success);
        $this->assertEquals($result->data->email, $user->getEmail());
    }

    public function testMe_WithoutUser_ShouldFail(): void {
        // Arrange
        $query = new MeQuery();

        // Act
        /* @var ApiResponse<MeResponse> $result */
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertFalse($result->success);
        $this->assertEquals(404, $result->statusCode);
        $this->assertEquals("Current user not found.", $result->error["message"]);
    }
}