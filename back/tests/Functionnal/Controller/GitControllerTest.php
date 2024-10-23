<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

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
        $client = self::createClient();
        $client->followRedirects(true);

        $client->request(
            Request::METHOD_POST,
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
        $client = self::createClient();
        $client->followRedirects(true);

        $client->request(Request::METHOD_GET, '/git/show');
        $content = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        self::assertJson($content);
        self::assertSame('0.0.7', json_decode($content, true, 512, JSON_THROW_ON_ERROR)['tag']);
    }

    private function getContentJson(): string
    {
        return file_get_contents(self::DEPLOY_RESULT_JSON_PATH);
    }
}
