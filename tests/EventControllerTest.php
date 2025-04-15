<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testCreateEvent(): void
    {
        $client = static::createClient();

        $data = [
            'name' => 'Symfony 7 Meetup',
            'location' => 'Berlin',
            'date' => '2025-04-30 18:00:00'
        ];

        $client->request(
            'POST',
            '/api/events',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201); // assuming you return 201 Created

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($data['name'], $responseData['name']);
        $this->assertEquals($data['location'], $responseData['location']);
    }
}
