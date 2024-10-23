<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Newsletter;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

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

        $client->request(Request::METHOD_GET, '/newsletter/content/show/?date=2021-01-03');

        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
        $this->assertResponseIsSuccessful();
    }

    public function test_sunday(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newsletter/content/show/?date=2021-01-01');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }

    public function test_saturday(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newsletter/content/show/?date=2021-01-02');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2#test-see-again');
    }

    public function test_all(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newsletter/content/all');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-img-random', 'Images de');
    }

    public function test_all_denormalization(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request(Request::METHOD_GET, '/newsletter/content/show/?date=2021-01-04&force_twig=true');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2#test-see-again');
    }
}
