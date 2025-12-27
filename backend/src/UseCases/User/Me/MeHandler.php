<?php

namespace App\UseCases\User\Me;

use App\Dtos\ApiResponse;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AsMessageHandler]
class MeHandler
{
    function __construct(
        private Security $security,
    )
    {
    }

    /**
     * @return ApiResponse<MeResponse>
     */
    public function __invoke(MeQuery $query): ApiResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return ApiResponse::notFound("Current user not found.");
        }

        return ApiResponse::success(new MeResponse(email: $user->getUserIdentifier()));
    }
}