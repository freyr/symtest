<?php

namespace App\Tests\Pact;

use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Consumer\Model\ConsumerRequest;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AuthorsApiConsumerPactTest extends TestCase
{
    public function testGetAuthorsPact(): void
    {
        $config = new MockServerConfig();
        $config
            ->setConsumer('AuthorsConsumer')
            ->setProvider('AuthorsApi')
            ->setPactDir(__DIR__ . '/pacts')
            ->setHost('pact-mock-server');

        $matcher = new Matcher();
        $interactionBuilder = new InteractionBuilder($config);

        $consumerRequest = (new ConsumerRequest())
            ->setMethod('GET')
            ->setPath('/api/authors/');

        $providerResponse = (new ProviderResponse())
            ->setStatus(200)
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setBody(
                $matcher->eachLike([
                    'id' => $matcher->integer(1),
                    'name' => $matcher->like('John Doe'),
                    'email' => $matcher->like('john@example.com'),
                ])
            );

        $interactionBuilder
            ->given('authors exist')
            ->uponReceiving('a request for authors list')
            ->with($consumerRequest)
            ->willRespondWith($providerResponse);

        // Make request to mock server
        // this should be real client service that will call underlying api
        $client = new Client(['base_uri' => 'http://pact-mock-server:7200']);
        $response = $client->get('/api/authors/');


        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);

        // Verify interaction and write pact
        $this->assertTrue($interactionBuilder->verify());
        $interactionBuilder->finalize();
    }

    public function testCreateAuthorPact(): void
    {
        $config = new MockServerConfig();
        $config
            ->setConsumer('AuthorsConsumer')
            ->setProvider('AuthorsApi')
            ->setPactDir(__DIR__ . '/pacts')
            ->setHost('pact-mock-server');

        $matcher = new Matcher();
        $payload = ['name' => 'Jane Doe', 'email' => 'jane@example.com'];
        $interactionBuilder = new InteractionBuilder($config);

        $consumerRequest = (new ConsumerRequest())
            ->setMethod('POST')
            ->setPath('/api/authors/')
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setBody($payload);

        $providerResponse = (new ProviderResponse())
            ->setStatus(201)
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setBody([
                'id' => $matcher->integer(2),
                'name' => $payload['name'],
                'email' => $payload['email'],
            ]);

        $interactionBuilder
            ->given('can create an author')
            ->uponReceiving('a request to create an author')
            ->with($consumerRequest)
            ->willRespondWith($providerResponse);

        // Make request to mock server
        $client = new Client(['base_uri' => 'http://pact-mock-server:7200']);
        $response = $client->post('/api/authors/', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $payload
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertSame($payload['name'], $data['name']);
        $this->assertSame($payload['email'], $data['email']);

        // Verify interaction and write pact
        $this->assertTrue($interactionBuilder->verify());
        $interactionBuilder->finalize();
    }
}
