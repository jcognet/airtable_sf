<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Newspaper;

use Symfony\Component\HttpFoundation\Request;
use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class ContentControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newspaper/content/one/article?date=2021-01-03');

        $this->assertResponseIsSuccessful();
    }

    public function test_wrong_block(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newspaper/content/one/toto?date=2021-01-03');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
