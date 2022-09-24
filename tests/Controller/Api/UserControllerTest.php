<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testGetAction(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            null
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testGetSingleAction(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/user/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            null
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testPostAction(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "username": "test",
                "password" : "test",
                "fullName": "Usuario test",
                "enabled": 1
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testEditAction(): void
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/user/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "username": "test",
                "password" : "test1234",
                "fullName": "Usuario test updated",
                "enabled": 1
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testDeleteAction(): void
    {
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/api/user/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            null
        );

        $this->assertEquals(204, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }
}
