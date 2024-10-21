<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Fooding;

use Symfony\Component\HttpFoundation\Request;
use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class HealthControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/fooding/health');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de');
        $this->assertResponseIsSuccessful();
    }

    public function test_list_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/fooding/health/list');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de santé depuis le début');
        $this->assertResponseIsSuccessful();
    }

    public function test_date(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/fooding/health?month=2023-09');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de');
        $this->assertSelectorTextContains('span.test-coffee', '25');
        $this->assertSelectorTextContains('span.test-meat', '17');
        $this->assertSelectorExists('a.text-next-month');
        $this->assertResponseIsSuccessful();
    }

    public function test_wrong_date(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/fooding/health?date=223-213(123123');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de');
        $this->assertResponseIsSuccessful();
    }
}
