<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;

#[Route('/api', name: 'api_')]
final class BookingController extends AbstractController
{
    #[Route('/add/booking', name: 'booking_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);

        $now = new \DateTime();
        $booking = new Booking();
        $booking->setEventId($post_data['event_id']);
        $booking->setAttendeeId($post_data['attendee_id']);
        $booking->setCreatedBy($post_data['user_id']);
        $booking->setCreatedOn($now);

        $entityManager->persist($booking);
        $entityManager->flush();

        $data =  [
            'id' => $booking->getId(),
            'event_id' => $booking->getEventId(),
        ];

        return $this->json($data);
    }
}
