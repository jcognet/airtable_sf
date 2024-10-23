<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class ImageControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/img/list/?directory=MjAyMS9kaXIy');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }

    public function test_unknown_directory(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/img/list/?directory=MjAyMS9kaXI');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_random(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/img/random/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }
}
