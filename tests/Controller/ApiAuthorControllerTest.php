<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAuthorControllerTest extends WebTestCase
{
    public function testListAuthors()
    {
        $client = static::createClient();
        $client->request('GET', '/api/authors/');
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');
        $data = json_decode($client->getResponse()->getContent(), true);
        self::assertIsArray($data);
        self::assertNotEmpty($data, 'Authors list should not be empty (fixtures should provide authors)');
        $author = $data[0];
        self::assertArrayHasKey('id', $author);
        self::assertArrayHasKey('name', $author);
        self::assertArrayHasKey('email', $author);
    }
}
