<?php

namespace App\Validations;

use App\Entity\Attendee;
use App\Entity\Users;
use App\Utils\ValidateFields;
use App\Entity\Booking;
use App\Entity\Event;

class Validate
{

  /**
   * Attendee validations.
   */
  public static function validateAttendee($entityManager, $post_data) {
    // Field validations.
    $fields = implode(',', array_keys($post_data));
    if (!ValidateFields::validateRequiredFields($post_data, ['name', 'email', 'city', 'state', 'country', 'user_id'])) {
      return 'Either fields(' . $fields . ') names not correct or values are not provided.';
    }

    $find_user = $entityManager->getRepository(Users::class)->findOneBy([
      'id' => $post_data['user_id'],
    ]);
    if (!$find_user) {
      return 'User Id does not match.';
    }

    $find_attendee = $entityManager->getRepository(Attendee::class)->findOneBy([
      'email' => $post_data['email'],
    ]);
    if ($find_attendee) {
      return 'Attendee exist with same email id.';
    }
  }

  /**
   * Booking validations.
   */
  public static function validateBooking($entityManager, $post_data) {
    // Validations.
    $find_event = $entityManager->getRepository(Event::class)->findOneBy([
      'id' => $post_data['event_id'],
    ]);
    if (!$find_event) {
      return 'Event Id does not match.';
    }

    $find_attendee = $entityManager->getRepository(Attendee::class)->findOneBy([
      'id' => $post_data['attendee_id'],
    ]);
    if (!$find_attendee) {
      return 'Attendee Id does not match.';
    }

    $find_user = $entityManager->getRepository(Users::class)->findOneBy([
      'id' => $post_data['user_id'],
    ]);
    if (!$find_user) {
      return 'User Id does not match.';
    }

    $find_booking = $entityManager->getRepository(Booking::class)->findOneBy([
      'event_id' => $post_data['event_id'],
      'attendee_id' => $post_data['attendee_id'],
    ]);
    if ($find_booking) {
      return 'Booking exist for the event for the given attendee.';
    }

    $event_count = $entityManager->getRepository(Booking::class)->countEventBooking($post_data['event_id']);
    $max_attendee = $find_event->getMaxAttendees();
    if ($event_count >= $max_attendee) {
      return 'Booking not allowed, capacity exhausted.';
    }
  }

  /**
   * Event validations.
   */
  public static function validateEvent($entityManager, $post_data) {
      // Field validations.
      $fields = implode(',', array_keys($post_data));
      if (!ValidateFields::validateRequiredFields($post_data, ['name', 'description', 'location', 'start_date', 'end_date', 'status', 'created_by', 'max_attendees'])) {
          return 'Either fields(' . $fields . ') names not correct or values are not provided.';
      }
      $find_user = $entityManager->getRepository(Users::class)->findOneBy([
          'id' => $post_data['created_by'],
      ]);
      if (!$find_user) {
          return 'User Id does not match.';
      }

      $start_date = new \DateTime($post_data['start_date']);
      $end_date = new \DateTime($post_data['end_date']);

      $find_event = $entityManager->getRepository(Event::class)->findOneBy([
          'start_date' => $start_date,
          'end_date' => $end_date,
      ]);
      if ($find_event) {
          return 'Events exists for same date and time';
      }
      if (strtotime($post_data['end_date']) < strtotime($post_data['start_date'])) {
          return 'Start date time should be greater than end date time.';
      }
  }

  /**
   * Event update validations.
   */
  public static function validateUpdateEvent($entityManager, $post_data, $id) {
    $event = $entityManager->getRepository(Event::class)->find($id);
    if (!$event) {
      return 'No event found for id ' . $id;
    }
    // Field validations.
    $fields = implode(',', array_keys($post_data));
    if (!ValidateFields::validateRequiredFields($post_data, ['name', 'description', 'location', 'start_date', 'end_date', 'status', 'created_by', 'max_attendees'])) {
      return 'Either fields(' . $fields . ') names not correct or values are not provided.';
    }
    $find_user = $entityManager->getRepository(Users::class)->findOneBy([
      'id' => $post_data['created_by'],
    ]);
    if (!$find_user) {
      return 'User Id does not match.';
    }
  }

  /**
   * Validate users.
   */
  public static function validateUsers($entityManager, $post_data) {
    // Field validations.
    $fields = implode(',', array_keys($post_data));
    if (!ValidateFields::validateRequiredFields($post_data, ['name', 'email'])) {
      return 'Either fields(' . $fields . ') names not correct or values are not provided.';
    }

    $find_user = $entityManager->getRepository(Users::class)->findOneBy([
      'email' => $post_data['email']
    ]);
    if ($find_user) {
      return 'User exists with email id ' . $post_data['email'];
    }
  }

}
