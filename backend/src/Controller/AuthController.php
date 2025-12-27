<?php

namespace App\Controller;

use App\Dtos\ApiResponse;
use App\UseCases\CommandBus;
use App\UseCases\User\RegisterUser\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class AuthController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(#[MapRequestPayload] RegisterUserCommand $command): Response
    {
        /* @var ApiResponse<RegisterUserCommand> $response */
        $response = $this->commandBus->execute($command);

        return new JsonResponse($response, $response->statusCode);
    }
}
