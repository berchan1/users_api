<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/api_user', name: 'api_user', methods: 'GET')]
    public function api_user(EntityManagerInterface $entityManager): JsonResponse
    {
//        $user = new User();
//        $user->setEmail('test@wp.pl')->setFirstName('imie')->setLastName('nazwisko')->setPassword('test_possword');
//        $this->createUser($user);
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();
        dd($users);
        return $this->json(['test' => 'ok'], Response::HTTP_OK);
    }
}
