<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase {

    /**
     * Create event test.
     */
    public function testCreateEvent(): void {
        $client = static::createClient();
        $data = [
            "name" => "Test event",
            "description" => "Test description",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s", strtotime('+100 day')),
            "end_date" => date("Y-m-d h:i:s", strtotime('+101 day')),
            "status" => 1,
            "created_by" => $this->createUser($client),
            "max_attendees" => 100
        ];
        $result = $this->createEvent($data, $client);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($data['name'], $result['name']);
        $this->assertEquals($data['location'], $result['location']);
    }

    /**
     * Update event test.
     */
    public function testUpdateEvent(): void {
        $client = static::createClient();
        $data = [
            "name" => "Test event",
            "description" => "Test description",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s", strtotime('+5 day')),
            "end_date" => date("Y-m-d h:i:s", strtotime('+6 day')),
            "status" => 1,
            "created_by" => $this->createUser($client),
            "max_attendees" => 100
        ];
        $event = $this->createEvent($data, $client);
        $id = $event['id'];

        $modified_data = [
            "name" => "Test event Modified",
            "description" => "Test description Modified",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s", strtotime('+5 day')),
            "end_date" => date("Y-m-d h:i:s", strtotime('+6 day')),
            "status" => 1,
            "created_by" => $this->createUser($client),
            "max_attendees" => 100
        ];

        $client->request(
            'PUT',
            '/api/event/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($modified_data)
        );
        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data'];
        $this->assertArrayHasKey('id', $result);
        $this->assertStringContainsStringIgnoringCase('modified', $result['name']);
        $this->assertStringContainsStringIgnoringCase('modified', $result['description']);
    }

    /**
     * Get event test.
     */
    public function testGetEvent(): void {
        $client = static::createClient();
        $data = [
            "name" => "Test event",
            "description" => "Test description",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s", strtotime('+1 day')),
            "end_date" => date("Y-m-d h:i:s", strtotime('+2 day')),
            "status" => 1,
            "created_by" => 1,
            "max_attendees" => 100
        ];
        $event = $this->createEvent($data, $client);
        $id = $event['id'];

        $client->request(
            'GET',
            '/api/event/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data'];
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($data['name'], $result['name']);
        $this->assertEquals($data['location'], $result['location']);
    }

    /**
     * Delete event test.
     */
    public function testDeleteEvent(): void {
        $client = static::createClient();
        $data = [
            "name" => "Test event",
            "description" => "Test description",
            "location" => "Australia",
            "start_date" => date("Y-m-d h:i:s", strtotime('+3 day')),
            "end_date" => date("Y-m-d h:i:s", strtotime('+4 day')),
            "status" => 1,
            "created_by" => 1,
            "max_attendees" => 100
        ];
        $event = $this->createEvent($data, $client);
        $id = $event['id'];

        $message = 'Deleted a event successfully with id ' . $id;
        $client->request(
            'DELETE',
            '/api/event/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $result = json_decode($client->getResponse()->getContent(), true);
        $result = $result['data']['message'];
        $this->assertEquals($message, $result);
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

}
