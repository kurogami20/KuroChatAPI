<?php

namespace App\Controller;

use App\Entity\Conversation;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/api/v1')]
final class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $bearerToken = $request->headers->get('Authorization');
        if(!$bearerToken){
            return new JsonResponse([
                'message' => 'Authorization token missing',
                'status' => 'error'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Invalid request data',
                'status' => 'error'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        $text = $data['text'] ?? null;
        if (!$text) {
            return new JsonResponse([
                'message' => 'Question text is required',
                'status' => 'error'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        $conversationId = $data['conversation_id'] ?? null;
        if (!$conversationId) {
            return new JsonResponse([
                'message' => 'Conversation ID is required',
                'status' => 'error'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        $conversation = $entityManager->getRepository(Conversation::class)->find($conversationId);
        if (!$conversation) {
            return new JsonResponse([
                'message' => 'Conversation not found',
                'status' => 'error'
            ], JsonResponse::HTTP_NOT_FOUND);
        }
        $newQuestion = new Question();
        $newQuestion->setText($text);
        $newQuestion->setConversationId($conversation);
        $entityManager->persist($newQuestion);
        $entityManager->flush();


        return $this->json([
            'message' => 'Question created successfully',
            'data' => $newQuestion->getText(),
        ]);
    }
}
