<?php

namespace App\Controller;

use App\Repository\UserRepository;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiDeleteUserController extends AbstractController
{
    #[Route('/delete/{id}', name: 'api_delete', methods: 'DELETE')]
    /**
     * deletes user with given id
     *
     * @OA\Get(
     *     path="/api/delete/{id}",
     *     @OA\Parameter(name="id"),
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(response="200", ref="#/components/responses/200")
     * )
     */
    public function delete(int $id, Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($id);
        if ($user === null) {
            return new Response("user not found", 404);
        }
        $repository->remove($user, true);

        return new Response("user has been deleted", 200);
    }
}