<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Fooding;

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

        $client->request('GET', '/fooding/health');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de');
        $this->assertResponseIsSuccessful();
    }

    public function test_wrong_date(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/fooding/health?date=223-213(123123');

        $this->assertSelectorTextContains('h1.test-fooding-health', 'Bilan de');
        $this->assertResponseIsSuccessful();
    }
}
