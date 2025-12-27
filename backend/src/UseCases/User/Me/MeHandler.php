<?php

namespace App\UseCases\User\Me;

use App\Dtos\ApiResponse;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MeHandler
{
    public function __construct(
        private Security $security,
    ) {
    }

    /**
     * @return ApiResponse<MeResponse>
     */
    public function __invoke(MeQuery $query): ApiResponse
    {
        $user = $this->security->getUser();

        if (! $user) {
            return ApiResponse::notFound('Current user not found.');
        }

        return ApiResponse::success(new MeResponse(email: $user->getUserIdentifier()));
    }
}
