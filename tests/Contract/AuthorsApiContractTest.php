<?php
namespace App\Tests\Contract;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorsApiContractTest extends WebTestCase
{
    public function testGetAuthorsContract(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/authors/');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        foreach ($data as $author) {
            $this->assertArrayHasKey('id', $author);
            $this->assertArrayHasKey('name', $author);
        }
    }

    public function testCreateAuthorContract(): void
    {
        $client = static::createClient();
        $payload = [
            'name' => 'Contract Test Author',
            'email' => 'contract-test@example.com'
        ];
        $client->request(
            'POST',
            '/api/authors/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertSame($payload['name'], $data['name']);
        $this->assertSame($payload['email'], $data['email']);
    }
}
