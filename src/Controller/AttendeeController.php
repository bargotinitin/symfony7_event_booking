<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Attendee;

#[Route('/api', name: 'api_')]
final class AttendeeController extends AbstractController
{
    #[Route('/add/attendee', name: 'attendee_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);

        $now = new \DateTime();
        $attendee = new Attendee();
        $attendee->setName($post_data['name']);
        $attendee->setEmail($post_data['email']);
        $attendee->setCity($post_data['city']);
        $attendee->setState($post_data['state']);
        $attendee->setCountry($post_data['country']);
        $attendee->setCreatedBy($post_data['user_id']);
        $attendee->setCreatedOn($now);

        $entityManager->persist($attendee);
        $entityManager->flush();

        $data =  [
            'id' => $attendee->getId(),
            'name' => $attendee->getName(),
            'email' => $attendee->getEmail(),
            'city' => $attendee->getCity(),
            'state' => $attendee->getState(),
            'country' => $attendee->getCountry(),
        ];

        return $this->json($data);
    }
}
