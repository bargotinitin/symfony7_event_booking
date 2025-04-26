<?php

namespace App\Model;

use App\Entity\Booking;

class BookingModel
{
    /**
     * Save data.
     */
    public static function saveData($entityManager, $post_data)
    {
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

      return $data;
    }
}
