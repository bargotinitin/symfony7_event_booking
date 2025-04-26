<?php

namespace App\Controller;

use App\Entity\Attendee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Model\BookingModel;
use App\Validations\Validate;

#[Route('/api', name: 'api_')]
final class BookingController extends AbstractController
{
    #[Route('/add/booking', name: 'booking_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $validate = Validate::validateBooking($entityManager, $post_data);
        if ($validate) {
            return $this->json($validate, 404);
        }
        $data = BookingModel::saveData($entityManager, $post_data);
        return $this->json($data);
    }
}
