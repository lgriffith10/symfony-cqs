<?php

namespace App\Security;

use App\Dtos\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

final readonly class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private readonly JWTTokenManagerInterface $jwtManager)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $user = $token->getUser();
        $jwt = $this->jwtManager->create($user);

        $apiResponse = ApiResponse::success([
            'token' => $jwt,
            'user' => $user->getUserIdentifier(),
        ]);

        $response = new JsonResponse($apiResponse, $apiResponse->statusCode);

        $response->headers->setCookie(new Cookie(
            'symfony-auth',
            $jwt,
            strtotime('+1 day'),
            '/',
            null,
            true,
            true,
            false,
            Cookie::SAMESITE_NONE
        ));

        return $response;
    }
}
