<?php

namespace App\Controller;

use App\Dto\ErrorDto;
use App\Dto\SuccessDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\Model\UsersModel;
use App\Utils\ArrayHelper;
use App\Validations\Validate;

#[Route('/api', name: 'api_')]
final class UsersController extends AbstractController
{


    #[Route('/users', name: 'users_index', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $data = UsersModel::getData($entityManager);
        return $this->json(new SuccessDto($data));
    }


    #[Route('/user', name: 'user_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $validate = Validate::validateUsers($entityManager, $post_data);
        if ($validate) {
            return $this->json(new ErrorDto($validate), 400);
        }
        $data = UsersModel::saveData($entityManager, $post_data);
        return $this->json(new SuccessDto($data));
    }
}
