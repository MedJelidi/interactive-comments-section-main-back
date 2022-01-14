<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Commenter;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommentController extends AbstractController
{
    private Serializer $serializer;

    #[Route('/comment', name: 'comment', methods: ["POST"])]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $jsonData = $request->toArray();

        $commenter = $doctrine
            ->getRepository(Commenter::class)
            ->find($jsonData['commenter']['id']);

        $comment = new Comment();
        $comment->setCommenter($commenter);
        $comment->setParentID($jsonData['parentID'] == -1 ? null : $jsonData['parentID']);
        $comment->setContent($jsonData['content']);
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->setScore($jsonData['score']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($comment);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->jsonSerializer();

        $data = $this->serializer->serialize($comment, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s',
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__', 'comments'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
        ]);
        return new JsonResponse(json_decode($data));
    }

    public function jsonSerializer()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    #[Route('/update_comment/{id}', name: 'update_comment', methods: ["PUT"])]
    public function updateComment(Request $request, ManagerRegistry $doctrine, string $id): Response
    {
        $entityManager = $doctrine->getManager();

        $jsonData = $request->toArray();

        $comment = $doctrine
            ->getRepository(Comment::class)
            ->find($id);

        $comment->setContent($jsonData['content']);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($comment);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->jsonSerializer();

        $data = $this->serializer->serialize($comment, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s',
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__', 'comments'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
        ]);
        return new JsonResponse(json_decode($data));
    }

    #[Route("/parent_comments", name: "parent_comments", methods: ["GET"])]
    public function getComments(ManagerRegistry $doctrine): Response
    {
        $comments = $doctrine->getRepository(Comment::class)->findParentComments();
        $this->jsonSerializer();

        $data = $this->serializer->serialize($comments, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s',
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__', 'comments'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
        ]);
        return new JsonResponse(json_decode($data));
    }

    #[Route("/replies/{parentID}", name: "replies", methods: ["GET"])]
    public function getRepliesOfComment(string $parentID, ManagerRegistry $doctrine): Response
    {
        $comments = $doctrine->getRepository(Comment::class)->findRepliesOfComment($parentID);
        $this->jsonSerializer();

        $data = $this->serializer->serialize($comments, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s',
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__', 'comments'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
        ]);
        return new JsonResponse(json_decode($data));
    }

    #[Route("/delete_comment/{id}", name: "delete_comment", methods: ["DELETE"])]
    public function deleteComment(ManagerRegistry $doctrine, string $id): Response
    {
        $entityManager = $doctrine->getManager();
        $comment = $doctrine->getRepository(Comment::class)->find($id);
        $entityManager->remove($comment);
        $entityManager->flush();
        return new JsonResponse([
                'message' => 'Comment removed!'
            ]
        );
    }
}
