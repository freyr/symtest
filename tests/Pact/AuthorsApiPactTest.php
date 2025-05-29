<?php
namespace App\Tests\Pact;

use PhpPact\Standalone\ProviderVerifier\Verifier;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Uri;

class AuthorsApiPactTest extends TestCase
{
    public function testPactVerification(): void
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('AuthorsApi')
            ->setProviderBaseUrl(new Uri('http://nginx:80')) // public API on localhost:8080
            ->setPublishResults(false);


        $verifier = new Verifier($config);
        try {
            $verifier->verifyFiles([
                __DIR__ . '/pacts/authorsconsumer-authorsapi.json'
            ]);
            $this->assertTrue(true); // Verification succeeded
        } catch (\Throwable $e) {
            $this->fail('Pact verification failed: ' . $e->getMessage());
        }
    }
}
