<?php

namespace App\Tests\Integrations\User;

use App\Repository\UserRepository;
use App\Tests\Integrations\BaseIntegrationTest;
use App\UseCases\User\Me\MeQuery;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        $id = $this->userRepository->findOneBy(['email' => 'test@test.com'])->getId();
        $this->as($id);

        // Act
        $result = $this->dispatchQuery($query);

        // Assert
        $this->assertNotNull($result->email);
        $this->assertEquals('test@test.com', $result->email);
    }

    public function testMe_WithoutUser_ShouldFail(): void {
        // Arrange
        $query = new MeQuery();

        // Assert
        $this->expectException(AccessDeniedException::class);

        // Act
        $this->dispatchQuery($query);
    }
}