<?php

namespace App\UseCases\User\Me;

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

    public function __invoke(MeQuery $query): MeResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedException();
        }

        return new MeResponse(email: $user->getUserIdentifier());
    }
}