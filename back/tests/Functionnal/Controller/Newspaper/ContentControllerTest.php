<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Newspaper;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class ContentControllerTest extends WebTestCase
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
        $client->request('GET', '/newspaper/content/one/passport?date=2022-01-03');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function test_wrong_block(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/newspaper/content/one/toto?date=2022-01-03');

        // Validate a successful response and some content
        $this->assertResponseStatusCodeSame(404);
    }
}
