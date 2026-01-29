<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1')]
final class UserController extends AbstractController
{
    #[Route('/login', name: 'app_user_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        return new JsonResponse([
                'message' => 'Welcome to the User API!',
                'status' => 'success'
            ]
        );
    }
    #[Route('/logout', name: 'app_user_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse([
                'message' => 'Welcome to the User API!',
                'status' => 'success'
            ]
        );
    }
    #[Route('/signin', name: 'app_user_signin', methods: ['POST'])]
    public function signin(): JsonResponse
    {
        return new JsonResponse([
                'message' => 'Welcome to the User API!',
                'status' => 'success'
            ]
        );
    }
}
