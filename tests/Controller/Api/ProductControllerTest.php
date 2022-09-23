<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetAction(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/product',
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
            '/api/product/1',
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
            '/api/product',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                 "code": "YUB",
                 "name": "Yubiz",
                 "description": "Sistema para micro y mediana empresas.",
                "url": "yubiz.puyu.pe",
                "image": "yubiz/img/static.jpg"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testEditAction(): void
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/product/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "code": "YuBiz New code",
                "name": "Yubiz edit",
                "description": "Sistema para micro y mediana empresas.",
                "url": "yubiz.puyu.pe",
                "image": "yubiz/img/static.jpg"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testDeleteAction(): void
    {
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/api/product/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            null
        );

        $this->assertEquals(204, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }
}
