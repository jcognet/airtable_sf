<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page;

use Symfony\Component\HttpFoundation\Request;
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
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/dashboard?date=2021-01-04');

        $this->assertResponseIsSuccessful();
    }

    public function test_example(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/example');

        $this->assertResponseIsSuccessful();
    }

    public function test_holiday(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/dashboard?holiday=true&date=2023-06-17');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-holiday');
    }

    public function test_holiday_last_day(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/dashboard?holiday=true&date=2023-06-24');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-holiday');
    }

    public function test_holiday_date(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/dashboard?date=2023-06-17');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-holiday');
    }
}
