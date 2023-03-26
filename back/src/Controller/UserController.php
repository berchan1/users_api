<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    private $doctrine;

    public function __construct(private UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/api_user', name: 'api_user', methods: 'GET')]
    public function api_user(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = new User();
        $user->setEmail('tt@wp.pl')->setFirstName('ten')->setLastName('shinhan')->setPassword('asdasdas');
        $this->createUser($user);
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();
        dd($users);
        return $this->json(['test' => 'ok'], Response::HTTP_OK);
    }

    private function createUser(User $requestData): bool
    {
        $entityManager = $this->doctrine->getManager();

        $user = (new User())
            ->setEmail($requestData->getEmail())
            ->setFirstName($requestData->getFirstName())
            ->setlastName($requestData->getLastName());

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $requestData->getPassword())
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return true;
    }
}
