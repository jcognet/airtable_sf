<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page\Alert;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 */
final class ShowControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/alert/?date=2025-02-21');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-alert', 'alertes');
        $this->assertSelectorTextContains('#test-alert-abs_max_series', '16');
        $this->assertSelectorTextContains('#test-alert-meat_current_without_series', '0');
        $this->assertSelectorTextContains('#test-alert-abs_current_series', '3');
        $this->assertSelectorTextContains('#test-alert-abs', '6');
        $this->assertSelectorTextContains('#test-alert-cut', '4');
        $this->assertSelectorTextContains('#test-alert-qi', '1');
        $this->assertSelectorTextContains('#test-alert-coloring', '15');
    }
}
