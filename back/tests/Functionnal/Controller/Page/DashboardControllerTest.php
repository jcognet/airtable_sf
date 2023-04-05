<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class DashboardControllerTest extends WebTestCase
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
        $client->request('GET', '/dashboard?date=2022-01-04');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_example(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/example');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
