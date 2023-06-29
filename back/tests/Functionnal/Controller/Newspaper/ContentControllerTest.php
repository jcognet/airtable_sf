<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Newspaper;

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

        $client->request('GET', '/newspaper/content/one/passport?date=2022-01-03');

        $this->assertResponseIsSuccessful();
    }

    public function test_wrong_block(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/newspaper/content/one/toto?date=2022-01-03');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
