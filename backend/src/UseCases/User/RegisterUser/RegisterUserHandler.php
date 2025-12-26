<?php

namespace App\UseCases\User\RegisterUser;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class RegisterUserHandler
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private Security $security,
    )
    {
    }

    public function __invoke(RegisterUserCommand $command): RegisterUserResponse
    {
        $user = $this->security->getUser();

        $existingUser = $this->entityManager->getRepository(User::class)->count(['email' => $command->email]);


        if ($existingUser != 0) {
            throw new \Exception("Email already in use.");
        }

        $user = new User();

        $user->setId(Uuid::v7());
        $user->setEmail($command->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $command->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new RegisterUserResponse(
            id: $user->getId()
        );
    }
}