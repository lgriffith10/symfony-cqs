<?php

namespace App\Controller;

use App\UseCases\CommandBus;
use App\UseCases\User\RegisterUser\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class AuthController extends AbstractController
{
    function __construct(
        private readonly CommandBus $commandBus,
    )
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(#[MapRequestPayload] RegisterUserCommand $command): Response {
        $response = $this->commandBus->execute($command);
        return new JsonResponse($response, $response->statusCode);
    }
}
