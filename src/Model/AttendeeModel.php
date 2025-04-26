<?php

namespace App\Model;

use App\Entity\Attendee;

class AttendeeModel
{
    /**
     * Save data.
     */
    public static function saveData($entityManager, $post_data)
    {
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
      return $data;
    }
}
