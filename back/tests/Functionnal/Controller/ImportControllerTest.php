<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class ImportControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_import(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        // Request a specific page
        $client->request('GET', '/import/all');
        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertJson($content);
    }
}
