<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/api_user', name: 'api_user', methods: 'GET')]
    public function api_user(): JsonResponse
    {
//        dd('test');
        return $this->json(['test' => 'ok'], Response::HTTP_OK);
    }
}