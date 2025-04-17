<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Attendee;
use App\Entity\Users;
use App\Utils\ArrayHelper;
#[Route('/api', name: 'api_')]
final class AttendeeController extends AbstractController
{
    #[Route('/add/attendee', name: 'attendee_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);

        // Field validations.
        $fields = implode(',', array_keys($post_data));
        if (!ArrayHelper::validateRequiredFields($post_data, ['name', 'email', 'city', 'state', 'country', 'user_id'])) {
            return $this->json('Either fields(' . $fields . ') names not correct or values are not provided.', 404);
        }

        $now = new \DateTime();

        $find_user = $entityManager->getRepository(Users::class)->findOneBy([
            'id' => $post_data['user_id'],
        ]);
        if (!$find_user) {
            return $this->json('User Id does not match.', 404);
        }

        $find_attendee = $entityManager->getRepository(Attendee::class)->findOneBy([
            'email' => $post_data['email'],
        ]);
        if ($find_attendee) {
            return $this->json('Attendee exist with same email id.', 404);
        }

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
