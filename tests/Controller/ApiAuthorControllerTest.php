<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAuthorControllerTest extends WebTestCase
{
    public function testListAuthors()
    {
        $client = static::createClient();
        $client->request('GET', '/api/authors/');
        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data, 'Authors list should not be empty (fixtures should provide authors)');
        $author = $data[0];
        $this->assertArrayHasKey('id', $author);
        $this->assertArrayHasKey('name', $author);
        $this->assertArrayHasKey('email', $author);
    }
}
