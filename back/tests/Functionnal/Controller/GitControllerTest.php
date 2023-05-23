<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @internal
 */
final class GitControllerTest extends WebTestCase
{
    private const DEPLOY_JSON_PATH = __DIR__ . '/../../data/test/deploy.json';
    private const DEPLOY_RESULT_JSON_PATH = __DIR__ . '/../../data/test/deploy_result.json';
    private string $content = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->content = $this->getContentJson();
    }

    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->dumpFile(self::DEPLOY_RESULT_JSON_PATH, $this->content);
        parent::tearDown();
    }

    public function test_deploy(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);

        // Request a specific page
        $client->request(
            'POST',
            '/git/deploy',
            [],
            [],
            ['HTTP_X-Hub-Signature-256' => 'sha256=584efbcc4289a124c81e5cac7b48e2dc31916a8d514f2b7ca5f86fc7a9498c46'],
            file_get_contents(self::DEPLOY_JSON_PATH)
        );
        $this->assertResponseIsSuccessful();
        $this->assertEmailCount(1);
    }

    public function test_version(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->followRedirects(true);

        // Request a specific page
        $client->request('GET', '/git/show');
        $content = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        static::assertJson($content);
        static::assertSame('0.0.7', json_decode($content, true)['tag']);
    }

    private function getContentJson(): string
    {
        return file_get_contents(self::DEPLOY_RESULT_JSON_PATH);
    }
}
