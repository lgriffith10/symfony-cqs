<?php

namespace App\Security;

use App\Dtos\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Monolog\Handler\AbstractHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

final class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private readonly JWTTokenManagerInterface $jwtManager) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $user = $token->getUser();
        $jwt = $this->jwtManager->create($user);

        $apiResponse = ApiResponse::success([
            'token' => $jwt,
            'user'  => $user->getUserIdentifier()
        ]);

        return new JsonResponse($apiResponse, $apiResponse->statusCode);
    }
}