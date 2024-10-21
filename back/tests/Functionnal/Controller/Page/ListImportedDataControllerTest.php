<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page;

use Symfony\Component\HttpFoundation\Request;
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

        $client->request(Request::METHOD_GET, '/list_imported_data/to_read');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-list');
    }

    public function test_default_sort_desc(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/to_read?sort_field=title&sort_order=desc');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-list');
    }

    public function test_default_sort_asc(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/to_read?sort_field=title&sort_order=asc');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-list');
    }

    public function test_no_query(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_wrong_query(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/toto');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_data_imported_but_not_listable(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/holiday');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_data_imported_sorted_wrong_field(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/to_read?sort_field=toto&sort_order=asc');

        self::assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_data_imported_sorted_wrong_order(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/to_read?sort_field=title&sort_order=toto');

        self::assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_filter(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/list_imported_data/see_again?fetch=true&filter=neur');

        $this->assertResponseIsSuccessful();
    }
}
