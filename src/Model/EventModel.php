<?php

namespace App\Model;

use App\Entity\Event;

class EventModel
{
    /**
     * Save data.
     */
    public static function saveData($entityManager, $post_data)
    {
      $now = new \DateTime();
      $start_date = new \DateTime($post_data['start_date']);
      $end_date = new \DateTime($post_data['end_date']);

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
      return $data;
    }

    /**
     * Get data.
     */
    public static function getData($entityManager, $id) {
      $event = $entityManager->getRepository(Event::class)->find($id);
      if (!$event) {
        return 'No event found for id ' . $id;
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
      return $data;
    }

    /**
     * Get all data.
     */
    public static function getAllData($entityManager) {
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
      return $data;
    }

    /**
     * Delete data.
     */
    public static function deleteData($entityManager, $id) {
      $event = $entityManager->getRepository(Event::class)->find($id);

      if (!$event) {
        return 'No event found for id ' . $id;
      }

      $entityManager->remove($event);
      $entityManager->flush();

      $data = [
        'message' => 'Deleted a event successfully with id ' . $id,
      ];
      return $data;
    }

    /**
     * Update data.
     */
    public static function updateData($entityManager, $post_data, $id)
    {
      $now = new \DateTime();
      $start_date = new \DateTime($post_data['start_date']);
      $end_date = new \DateTime($post_data['end_date']);

      $event = $entityManager->getRepository(Event::class)->find($id);
      $event->setName($post_data['name']);
      $event->setDescription($post_data['description']);
      $event->setStartDate($start_date);
      $event->setEndDate($end_date);
      $event->setMaxAttendees($post_data['max_attendees']);
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
      return $data;
    }

}
