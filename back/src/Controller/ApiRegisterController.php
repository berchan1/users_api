<?php

namespace App\Controller;

use App\DTO\User as UserDTO;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiRegisterController extends AbstractController
{
    private ManagerRegistry $doctrine;
    public function __construct(private UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    #[Route('/api_register', name: 'api_register', methods: 'GET')]
    public function register(Request $request, ValidatorInterface $validator): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $user = new UserDTO();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->createUser($user);

        return new Response("user has been registered", 200);
    }

    private function createUser(UserDTO $requestData): bool
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