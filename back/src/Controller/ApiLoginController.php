<?php

namespace App\Controller;

use App\Entity\User;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/api_login', name: 'api_login', methods: 'POST')]
    /**
     * logs in user
     *
     * @Route("/login", methods={"POST"})
     * @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"username":"imie_nazwisko@wp.pl","password":"test"}
     *             )
     *         )
     *     ),
     * @OA\Tag(name="login")
     */
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'username' => $user->getUserIdentifier(),
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