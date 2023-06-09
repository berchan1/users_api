<?php

namespace App\Controller;

use App\DTO\User as UserDTO;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiRegisterController extends AbstractController
{
    private ManagerRegistry $doctrine;
    public function __construct(private UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    #[Route('/api_register', name: 'api_register', methods: 'POST')]
    /**
     * registers user
     *
     * @Route("/api/register", methods={"POST"})
     * @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email":"imie_nazwisko@wp.pl","first_name":"imie","last_name":"nazwisko","password":"test"}
     *             )
     *         )
     *     ),
     * @OA\Tag(name="register")
     */
    public function register(Request $request, ValidatorInterface $validator, SerializerInterface $serializer): Response
    {
        $user = $serializer->deserialize($request->getContent(), \App\DTO\User::class, JsonEncoder::FORMAT);
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