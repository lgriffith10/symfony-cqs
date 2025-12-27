<?php

namespace App\Security;

use App\Dtos\ApiResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

final class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $apiResponse = ApiResponse::unauthorized();
        return new JsonResponse($apiResponse, $apiResponse->statusCode);
    }
}