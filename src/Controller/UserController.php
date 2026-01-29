<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1')]
final class UserController extends AbstractController
{

#[Route('/signin', name: 'app_user_signin', methods: ['POST'])]
    public function signin(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
       $data = json_decode($request->getContent(), true);


                if ($data){
                $newUser = new User();
                $newUser->setMail($data['mail']);
                $newUser->setPassword($data['password']);

                $plaintextPassword = $data['password'];

                $passwordHasher->hashPassword(
                            $newUser,
                            $plaintextPassword
                        );


                // $entityManager->persist($newUser);
                // $entityManager->flush();

                return new JsonResponse([
                        'user'=>$newUser->getMail(),
                    ]
                );} else {
                    return new JsonResponse([
                        'message' => 'Invalid data provided',
                        'status' => 'error'
                    ], 400);
                }
    }

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

}
