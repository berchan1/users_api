<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/api_user', name: 'api_user', methods: 'GET')]
    public function api_user(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'view']);
    }
}
