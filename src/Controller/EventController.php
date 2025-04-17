<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\Users;
use App\Utils\ArrayHelper;

#[Route('/api', name: 'api_')]
class EventController extends AbstractController
{
    #[Route('/event', name: 'event_index', methods:['get'] )]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $events = $entityManager
            ->getRepository(Event::class)
            ->findAll();

        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'description' => $event->getDescription(),
                'location' => $event->getLocation(),
                'start_date' => $event->getStartDate()->format('Y-m-d H:i:s'),
                'end_date' => $event->getEndDate()->format('Y-m-d H:i:s'),
                'max_attendees' => $event->getMaxAttendees(),
                'status' => $event->isStatus(),
                'created' => $event->getCreated()->format('Y-m-d H:i:s'),
                'changed' =>  $event->getChanged()->format('Y-m-d H:i:s'),
                'created_by' =>  $event->getCreatedBy(),
           ];
        }

        return $this->json($data);
    }


    #[Route('/event', name: 'event_create', methods:['post'] )]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);

        // Field validations.
        $fields = implode(',', array_keys($post_data));
        if (!ArrayHelper::validateRequiredFields($post_data, ['name', 'description', 'location', 'start_date', 'end_date', 'status', 'created_by', 'max_attendees'])) {
            return $this->json('Either fields(' . $fields . ') names not correct or values are not provided.', 404);
        }
        $find_user = $entityManager->getRepository(Users::class)->findOneBy([
            'id' => $post_data['created_by'],
        ]);
        if (!$find_user) {
            return $this->json('User Id does not match.', 404);
        }

        $now = new \DateTime();
        $start_date = new \DateTime($post_data['start_date']);
        $end_date = new \DateTime($post_data['end_date']);

        $find_event = $entityManager->getRepository(Event::class)->findOneBy([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        if ($find_event) {
            return $this->json('Events exists for same date and time', 404);
        }
        if (strtotime($post_data['end_date']) < strtotime($post_data['start_date'])) {
            return $this->json('Start date time should be greater than end date time.', 404);
        }

        $event = new Event();
        $event->setName($post_data['name']);
        $event->setDescription($post_data['description']);
        $event->setLocation($post_data['location']);
        $event->setStartDate($start_date);
        $event->setEndDate($end_date);
        $event->setMaxAttendees($post_data['max_attendees']);
        $event->setCreated($now);
        $event->setChanged($now);
        $event->setCreatedBy(1);
        $event->setStatus(1);

        $entityManager->persist($event);
        $entityManager->flush();

        $data =  [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'location' => $event->getLocation(),
        ];

        return $this->json($data);
    }


    #[Route('/event/{id}', name: 'event_show', methods:['get'] )]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {

            return $this->json('No event found for id ' . $id, 404);
        }

        $data =  [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start_date' => $event->getStartDate()->format('Y-m-d H:i:s'),
            'end_date' => $event->getEndDate()->format('Y-m-d H:i:s'),
            'max_attendees' => $event->getMaxAttendees(),
            'status' => $event->isStatus(),
            'created' => $event->getCreated()->format('Y-m-d H:i:s'),
            'changed' =>  $event->getChanged()->format('Y-m-d H:i:s'),
            'created_by' =>  $event->getCreatedBy(),
        ];

        return $this->json($data);
    }

    #[Route('/event/{id}', name: 'event_update', methods:['put', 'patch'] )]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            return $this->json('No event found for id ' . $id, 404);
        }


        $post_data = json_decode($request->getContent(), true);

        // Field validations.
        $fields = implode(',', array_keys($post_data));
        if (!ArrayHelper::validateRequiredFields($post_data, ['name', 'description', 'location', 'start_date', 'end_date', 'status', 'created_by', 'max_attendees'])) {
            return $this->json('Either fields(' . $fields . ') names not correct or values are not provided.', 404);
        }
        $find_user = $entityManager->getRepository(Users::class)->findOneBy([
            'id' => $post_data['created_by'],
        ]);
        if (!$find_user) {
            return $this->json('User Id does not match.', 404);
        }

        $now = new \DateTime();
        $start_date = new \DateTime($post_data['start_date']);
        $end_date = new \DateTime($post_data['end_date']);

        $event->setName($post_data['name']);
        $event->setDescription($post_data['description']);
        $event->setStartDate($start_date);
        $event->setEndDate($end_date);
        $event->setMaxAttendees($post_data['max_attendees']);
        // $event->setCreated($now);
        $event->setChanged($now);
        $event->setCreatedBy(1);
        $event->setLocation($post_data['location']);
        $event->setStatus(1);


        $entityManager->flush();

        $data =  [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'description' => $event->getDescription(),
                'location' => $event->getLocation(),
                'start_date' => $event->getStartDate()->format('Y-m-d H:i:s'),
                'end_date' => $event->getEndDate()->format('Y-m-d H:i:s'),
                'max_attendees' => $event->getMaxAttendees(),
                'status' => $event->isStatus(),
                'created' => $event->getCreated()->format('Y-m-d H:i:s'),
                'changed' =>  $event->getChanged()->format('Y-m-d H:i:s'),
                'created_by' =>  $event->getCreatedBy(),
        ];

        return $this->json($data);
    }

    #[Route('/event/{id}', name: 'event_delete', methods:['delete'] )]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            return $this->json('No event found for id ' . $id, 404);
        }

        $entityManager->remove($event);
        $entityManager->flush();

        return $this->json('Deleted a event successfully with id ' . $id);
    }
}
