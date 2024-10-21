<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page\Baby;

use Symfony\Component\HttpFoundation\Request;
use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

        $client->request(Request::METHOD_GET, '/life_event/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-events', 'Evénements importants');
    }
}
