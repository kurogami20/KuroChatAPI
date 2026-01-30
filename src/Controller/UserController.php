<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

#[Route('/api/v1')]
final class UserController extends AbstractController
{

    #[Route('/signin', name: 'app_user_signin', methods: ['POST'])]
        public function signin(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
        {
                // Decode the JSON request body into an associative array
                $data = json_decode($request->getContent(), true);

                if ($data){
                    // Create a new User entity instance
                    $newUser = new User();
                    $newUser->setMail($data['mail']);
                    $newUser->setPassword($data['password']);

                    // Validate the user entity against defined constraints
                    $validatorErrors = $validator->validate($newUser);
                    if (count($validatorErrors) > 0) {
                        $errorsString = (string) $validatorErrors;

                        return new JsonResponse([
                            'message' => 'Email or password invalid',
                            'status' => 'error',
                            'errors' => $errorsString
                        ], 400);
                    }

                    $plaintextPassword = $data['password'];

                    // Hash the password using the configured password hasher
                    $hashedPassword = $passwordHasher->hashPassword(
                        $newUser,
                        $plaintextPassword
                    );

                    // Replace plaintext password with hashed password
                    $newUser->setPassword($hashedPassword);

                    // Schedule the entity for insertion
                    $entityManager->persist($newUser);

                    // Execute the pending database operations
                    $entityManager->flush();

                    return new JsonResponse([
                        'user' => $newUser->getMail(),
                        'message' => 'User created successfully',
                        'status' => 'success'
                    ], 200);
                } else {
                    return new JsonResponse([
                        'message' => 'Invalid data provided',
                        'status' => 'error'
                    ], 400);
                }
        }

    #[Route('/login', name: 'app_user_login', methods: ['POST'])]
        public function login(Request $request,
        ValidatorInterface $validator,
         UserPasswordHasherInterface $passwordHasher,
          EntityManagerInterface $entityManager,
          JWTTokenManagerInterface $JWTManager
          ): JsonResponse
        {
            $data = json_decode($request->getContent(), true);

            if($data){
                $user = new User();
                $user->setMail($data['mail']);
                $user->setPassword($data['password']);
                $plaintextPassword = $data['password'];
                // Validate the input data
                $validatorErrors = $validator->validate($user);
                if (count($validatorErrors) > 0) {
                $errorsString = (string) $validatorErrors;

                return new JsonResponse([
                'message' => 'Email or password invalid',
                'status' => 'error',
                'errors' => $errorsString
                ], 400);
                }
                $actualUser = $entityManager->getRepository(User::class)->findOneBy(['mail' => $data['mail']?? null]);
                if (!$actualUser) {
                return new JsonResponse([
                'message' => 'Email or password invalid',
                'status' => 'error',
                ], 400);
                }

                if (!$passwordHasher->isPasswordValid($actualUser, $plaintextPassword)) {
                return new JsonResponse([
                'message' => 'Email or password invalid',
                'status' => 'error',
                ], 400);
                }
                $token = $JWTManager->create($actualUser);

                return new JsonResponse([
                'user' => $actualUser->getMail(),
                'message' => 'User logged in successfully',
                'status' => 'success',
                'token' => $token
                ], 200);

            }else{
            return new JsonResponse([
            'message' => 'Invalid data provided',
            'status' => 'error'
            ], 400);
            }

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
