<?php

namespace App\Controller;


use App\Entity\Conversation;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1')]
final class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'app_answer', methods: ['POST'])]
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
                'message' => 'Answer text is required',
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
        $newAnswer = new Answer();
        $newAnswer->setText($text);
        $newAnswer->setConversationId($conversation);
        $entityManager->persist($newAnswer);
        $entityManager->flush();


        return $this->json([
            'message' => 'Answer created successfully',
            'data' => $newAnswer->getText(),
        ]);
    }
}
