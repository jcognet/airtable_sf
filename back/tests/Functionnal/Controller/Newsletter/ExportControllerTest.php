<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Newsletter;

use Symfony\Component\HttpFoundation\Request;
use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class ExportControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newsletter/export/show/');

        $this->assertSelectorTextContains('h1.test-export', 'Export');
        $this->assertResponseIsSuccessful();
    }
}
