<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use Symfony\Component\HttpFoundation\Request;
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
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/import/all');

        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();

        self::assertJson($content);
    }
}
