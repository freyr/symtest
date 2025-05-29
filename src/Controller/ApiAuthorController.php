<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/authors', name: 'api_authors_')]
class ApiAuthorController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(AuthorRepository $authorRepository): JsonResponse
    {
        $authors = $authorRepository->findAll();
        $data = array_map(fn($author) => [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail(),
        ], $authors);
        return $this->json($data);
    }

    #[Route('/', name: 'add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name']) || !isset($data['email'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }
        $author = new Author();
        $author->setName($data['name']);
        $author->setEmail($data['email']);
        $author->setCreatedAt(new \DateTimeImmutable());
        $em->persist($author);
        $em->flush();
        return $this->json([
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update($id, Request $request, AuthorRepository $authorRepository, EntityManagerInterface $em): JsonResponse
    {
        $author = $authorRepository->find($id);
        if (!$author) {
            return $this->json(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (isset($data['name'])) {
            $author->setName($data['name']);
        }
        if (isset($data['email'])) {
            $author->setEmail($data['email']);
        }
        $em->flush();
        return $this->json([
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail(),
        ]);
    }
}
