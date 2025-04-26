<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttendeeControllerTest extends WebTestCase {

    public function testAttendeeCreate(): void
    {
        $client = static::createClient();

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
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($data['name'], $result['name']);
        $this->assertEquals($data['email'], $result['email']);
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
