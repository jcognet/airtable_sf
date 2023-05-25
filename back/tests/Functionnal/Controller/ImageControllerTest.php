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
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/img/list/?directory=2021/dir2');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }

    public function test_random(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/img/random/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }
}
