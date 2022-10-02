<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class TestMailControllerTest extends WebTestCase
{
    public function test_default(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-03');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_sunday(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-02');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_saturday(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-02');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_all(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/test/mail/all');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
