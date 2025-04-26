<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase {

    public function testUserCreate(): void
    {
        $client = static::createClient();

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
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($data['name'], $result['username']);
        $this->assertEquals($data['email'], $result['email']);
    }
}
