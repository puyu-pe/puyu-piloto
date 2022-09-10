<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyRepresentativeControllerTest extends WebTestCase
{
    public function testGetAction(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/company_representative',
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
            '/api/company_representative/3',
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
            '/api/company_representative',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Josefo",
                "lastName" : "Mendoza Onton",
                "phone": "983780023",
                "jobTitle": "Gerente"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testEditAction(): void
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/company_representative/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Rafaelo",
                "lastName" : "Pedraza Quinon",
                "phone": "983780025",
                "jobTitle": "Asistente"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }

    public function testDeleteAction(): void
    {
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/api/company_representative/3',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            null
        );

        $this->assertEquals(204, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }
}
