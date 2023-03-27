<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/api_login', name: 'api_login', methods: 'GET')]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = 'aasdasd'; // todo: create token

        return $this->json([
            'user'   => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: 'GET')]
    public function logout(): Response
    {
        return $this->json([
            'logout'  => 'success',
        ]);
    }
}