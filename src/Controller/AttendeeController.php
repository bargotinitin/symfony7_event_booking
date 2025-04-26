<?php

namespace App\Controller;

use App\Dto\ErrorDto;
use App\Dto\SuccessDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Validations\Validate;
use App\Model\AttendeeModel;
#[Route('/api', name: 'api_')]
final class AttendeeController extends AbstractController
{
    #[Route('/add/attendee', name: 'attendee_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $validate = Validate::validateAttendee($entityManager, $post_data);
        if ($validate) {
            return $this->json(new ErrorDto($validate), 400);
        }
        $data = AttendeeModel::saveData($entityManager, $post_data);
        return $this->json(new SuccessDto($data));
    }
}
