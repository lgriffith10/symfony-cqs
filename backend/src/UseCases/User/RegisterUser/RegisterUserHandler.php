<?php

namespace App\UseCases\User\RegisterUser;

use App\Dtos\ApiResponse;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class RegisterUserHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly Security $security,
    ) {
    }

    /**
     * @return ApiResponse<RegisterUserResponse>
     */
    public function __invoke(RegisterUserCommand $command): ApiResponse
    {
        $user = $this->security->getUser();

        $existingUser = $this->entityManager->getRepository(User::class)->count(['email' => $command->email]);

        if (0 != $existingUser) {
            return ApiResponse::error('User already exists.');
        }

        $user = new User();

        $user->setId(Uuid::v7());
        $user->setEmail($command->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $command->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return ApiResponse::created(new RegisterUserResponse($user->getId()));
    }
}
