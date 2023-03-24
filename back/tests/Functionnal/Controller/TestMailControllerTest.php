<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class TestMailControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-03');
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_sunday(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-02');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_saturday(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-01');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2#test-see-again');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_all(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/test/mail/all');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_all_denormalization(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/test/mail/show/?date=2022-01-04&force_twig=true');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2#test-see-again');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
