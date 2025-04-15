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

        $find_booking = $entityManager->getRepository(Booking::class)->findOneBy([
            'event_id' => $post_data['event_id'],
            'attendee_id' => $post_data['attendee_id'],
        ]);
        if ($find_booking) {
            return $this->json('Booking exist for the event for the given attendee.', 404);
        }

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
