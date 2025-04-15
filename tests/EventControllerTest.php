<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase {
    public function testCreateEvent(): void {
        $client = static::createClient();

        $data = [
            "name" => "Test event 101",
            "description" => "Test description 100",
            "location" => "Australia",
            "start_date" => "29-04-2025 09:25:00",
            "end_date" => "30-04-2025 20:25:00",
            "status" => 1,
            "created_by" => 1,
            "max_attendees" => 100
        ];

        $client->request(
            'POST',
            '/api/event',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $responseData = json_decode($client->getResponse()->getContent(), true);
        error_log(print_r($responseData, true));

        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($data['name'], $responseData['name']);
        $this->assertEquals($data['location'], $responseData['location']);
    }
}
