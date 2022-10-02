<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class ImageControllerTest extends WebTestCase
{
    public function test_default(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/img/list/?directory=2021/dir2');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_random(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:7000');
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/img/random/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
