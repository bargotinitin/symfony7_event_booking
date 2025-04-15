<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;

#[Route('/api', name: 'api_')]
final class UsersController extends AbstractController
{


    #[Route('/users', name: 'users_index', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $users = $entityManager
            ->getRepository(Users::class)
            ->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getUserName(),
                'email' => $user->getEmail(),
            ];
        }

        return $this->json($data);
    }


    #[Route('/user', name: 'user_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $now = new \DateTime();

        $password = bin2hex(random_bytes(10)); // random string
        $hashed = hash('sha256', $password);

        $user = new Users();
        $user->setUserName($post_data['name']);
        $user->setPassword($hashed);
        $user->setEmail($post_data['email']);

        $user->setCreated($now);
        $user->setChanged($now);
        $user->setStatus(1);

        $entityManager->persist($user);
        $entityManager->flush();

        $data =  [
            'id' => $user->getId(),
            'username' => $user->getUserName(),
            'email' => $user->getEmail(),
        ];

        return $this->json($data);
    }
}
