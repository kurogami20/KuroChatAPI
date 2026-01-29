<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1')]
final class ConversationController extends AbstractController
{
    #[Route('/conversations', name: 'app_conversation', methods: ['GET'])]
    public function allConversations(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConversationController.php',
        ]);
    }
    #[Route('/conversations/{id}', name: 'app_conversation', methods: ['GET'])]
    public function oneConversation(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConversationController.php',
        ]);
    }
 #[Route('/conversations', name: 'app_conversation', methods: ['POST'])]
    public function createConversation(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConversationController.php',
        ]);
    }

     #[Route('/conversations', name: 'app_conversation', methods: ['DELETE'])]
    public function deleteConversation(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConversationController.php',
        ]);
    }

}
