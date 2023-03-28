<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiDeleteUserController extends AbstractController
{
    #[Route('/delete/{id}', name: 'api_delete', methods: 'DELETE')]
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