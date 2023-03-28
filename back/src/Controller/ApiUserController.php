<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class ApiUserController extends AbstractController
{
    #[Route('/get_users', name: 'get_users', methods: 'GET')]
    /**
     * lists all users (without passwords)
     *
     * @Route("/get_users", methods={"GET"})
     * @OA\Tag(name="get_users")
     * )
     */
    public function get_users(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'view']);
    }
}
