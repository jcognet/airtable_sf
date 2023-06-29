<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Controller\Page\Question;

use App\Tests\Functionnal\SetUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class QuestionControllerTest extends WebTestCase
{
    use SetUserTrait;

    public function test_default(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/question/answer/recL16HTslPNn3UDq');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-question-h1', 'Qu\'est-ce que l\'homéostasie ?');
    }

    public function test_with_answer(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/question/answer/recL16HTslPNn3UDq?answer=Q2FwYWNpdMOpIGQndW5lIGJvdWNsZSBkZSByw6l0cm9hY3Rpb24gcG91ciBjaGFuZ2VyIGQnRXRhdCBxdWkgY29uc29tbWUgbW9pbnMgZCfDqW5lcmdpZS4=');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.test-question-h1', 'Qu\'est-ce que l\'homéostasie ?');
        $this->assertSelectorExists('div.is-danger');
        $this->assertSelectorExists('div.is-success');
        $this->assertSelectorExists('div.is-inverted');
    }

    public function test_random(): void
    {
        $client = self::createClient();
        $client->followRedirects(true);
        $this->loginUser($client);

        $client->request('GET', '/question');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1.test-question-h1');
    }
}
