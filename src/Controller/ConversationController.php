<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

#[Route('/api/v1')]
final class ConversationController extends AbstractController
{
    #[Route('/conversations', name: 'app_conversation', methods: ['POST'])]
        public function allConversations(EntityManagerInterface $entityManager, Request $request, JWTTokenManagerInterface $JWTManager): JsonResponse
        {
        $bearerToken = $request->headers->get('Authorization');
        if(!$bearerToken){
            return new JsonResponse([
                'message' => 'Authorization token missing',
                'status' => 'error'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $tokenDecoded = $JWTManager->parse(explode(' ', $bearerToken)[1] ?? '');
        if (!$tokenDecoded) {
            return new JsonResponse([
                'message' => 'Invalid token',
                'status' => 'error'
            ], Response::HTTP_UNAUTHORIZED);
        }
         $currentUser = $entityManager->getRepository(User::class)->findOneBy(['mail' => $tokenDecoded['username']?? null]);
            if (!$currentUser) {
                return new JsonResponse([
                    'message' => 'User not found',
                    'status' => 'error'
                ], Response::HTTP_UNAUTHORIZED);
            }

        $conversations = $entityManager->getRepository(Conversation::class)->findAll(['user_id'=>$currentUser->getId()]);

        return $this->json([
        'message' => 'all conversations found',
        'data' => $conversations,
        ]);
        }
    #[Route('/conversation', name: 'app__one_conversation', methods: ['POST'])]
        public function oneConversation(Request $request, EntityManagerInterface $entityManager, JWTTokenManagerInterface $JWTManager): JsonResponse
        {
            $bearerToken = $request->headers->get('Authorization');
            if(!$bearerToken){
                return new JsonResponse([
                    'message' => 'Authorization token missing',
                    'status' => 'error'
                ], Response::HTTP_UNAUTHORIZED);
            }
            $data = json_decode($request->getContent(), true);
            if (!isset($data['id'])) {
                return new JsonResponse([
                    'message' => 'Conversation ID is required',
                    'status' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }
            $tokenDecoded = $JWTManager->parse(explode(' ', $bearerToken)[1] ?? '');
            if (!$tokenDecoded) {
                return new JsonResponse([
                    'message' => 'Invalid token',
                    'status' => 'error'
                ], Response::HTTP_UNAUTHORIZED);
            }
            $currentUser = $entityManager->getRepository(User::class)->findOneBy(['mail' => $tokenDecoded['username']?? null]);
            if (!$currentUser) {
                return new JsonResponse([
                    'message' => 'User not found',
                    'status' => 'error'
                ], Response::HTTP_UNAUTHORIZED);
            }
            $oneConversation = $entityManager->getRepository(Conversation::class)->findOneBy(['id'=>$data['id'], 'user_id'=>$currentUser->getId()]);
            if (!$oneConversation) {
                return new JsonResponse([
                    'message' => 'Conversation not found',
                    'status' => 'error'
                ], Response::HTTP_NOT_FOUND);
            }
        return $this->json([
        'message' => 'Here is the conversation you asked for',
        'data' => $oneConversation,
        ]);
        }
    #[Route('/conversations/create', name: 'app_conversation_create', methods: ['POST'])]
        public function createConversation(): JsonResponse
        {
        return $this->json([
        'message' => 'Welcome to your new controller!',
        'path' => 'src/Controller/ConversationController.php',
        ]);
        }

    #[Route('/conversations/delete', name: 'app_conversation_delete', methods: ['DELETE'])]
        public function deleteConversation(): JsonResponse
        {
        return $this->json([
        'message' => 'Welcome to your new controller!',
        'path' => 'src/Controller/ConversationController.php',
        ]);
        }

}
