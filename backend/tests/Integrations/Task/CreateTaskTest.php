<?php

namespace Integrations\Task;

use App\Entity\User;
use App\Repository\UserRepository;
use Integrations\BaseIntegrationTest;

class CreateTaskTest extends BaseIntegrationTest
{
    private UserRepository $userRepository;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
        $this->user = $this->userRepository->findOneBy(['email', 'test@test.com']);

        $this->as($this->user->getId());
    }

    public function testShouldSucceed(): void
    {
    }
}
