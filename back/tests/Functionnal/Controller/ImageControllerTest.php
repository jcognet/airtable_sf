<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class ImageControllerTest extends WebTestCase
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
        $client->request('GET', '/img/list/?directory=2021/dir2');
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_random(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/img/random/');
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
