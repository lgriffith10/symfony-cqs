<?php

declare(strict_types=1);

namespace App\Controller;

use App\UseCases\QueryBus;
use App\UseCases\User\Me\MeQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class UserController extends AbstractController
{
    function __construct(private readonly QueryBus $queryBus)
    {
    }

    #[Route('/me', name: 'app_me', methods: ['GET'])]
    public function index(): Response
    {
        $response = $this->queryBus->query(new MeQuery());
        return $this->json($response, $response->statusCode);
    }
}
