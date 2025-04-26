<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase {

    public function testBookingCreate(): void
    {
        $client = static::createClient();

        $user_id = $this->createUser($client);
        $data = [
            "name" => "Test event",
            "description" => "Test description",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s"),
            "end_date" => date("Y-m-d h:i:s", strtotime('tomorrow')),
            "status" => 1,
            "created_by" => $user_id,
            "max_attendees" => 100
        ];
        $event = $this->createEvent($data, $client);
        $event_id = $event['id'];

        $attendee_id = $this->createAttendee($client);

        $booking_data = [
            'user_id' => $user_id,
            'event_id' => $event_id,
            'attendee_id' => $attendee_id
        ];
        $client->request(
            'POST',
            '/api/add/booking',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($booking_data)
        );

        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data'];
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($event_id, $result['event_id']);
    }

    /**
     * Create actual event.
     */
    public function createEvent($data, $client): array {
        $client->request(
            'POST',
            '/api/event',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
        $event = json_decode($client->getResponse()->getContent(), true);
        $event = $event['data'];
        return $event;
    }

    /**
     * Create actual user.
     */
    public function createUser($client): int
    {
        $name = "user" . rand(1, 999);
        $email = "user" . rand(9999, 9999999) . 'test@email.com';
        $data = [
            "name" => $name,
            "email" => $email,
        ];
        $client->request(
            'POST',
            '/api/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data'];
        return $result['id'];
    }

    /**
     * Create acutal attendee.
     */
    public function createAttendee($client): int {
        $name = "user" . rand(1, 999);
        $email = "user" . rand(9999, 9999999) . 'test@email.com';
        $data = [
            "name" => $name,
            "email" => $email,
            'city' => 'London',
            'state' => 'London',
            'country' => 'UK',
            'user_id' => $this->createUser($client),
        ];
        $client->request(
            'POST',
            '/api/add/attendee',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data'];
        return $result['id'];
    }

}
