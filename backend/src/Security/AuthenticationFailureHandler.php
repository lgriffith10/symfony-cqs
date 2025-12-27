<?php

namespace App\Security;

use App\Dtos\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

final readonly class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $apiResponse = ApiResponse::error('Invalid credentials', Response::HTTP_UNAUTHORIZED);

        return new JsonResponse($apiResponse, $apiResponse->statusCode);
    }
}
