<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class ListImportedDataControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/list_imported_data/to_read');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-list');
    }

    public function test_no_query(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/list_imported_data');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_wrong_query(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/list_imported_data/toto');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_data_imported_but_not_listable(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/list_imported_data/questions');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
