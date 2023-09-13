<?php
declare(strict_types=1);

namespace App\Tests\Functionnal\Command;

use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @internal
 */
final class NewspaperHandlerCommandTest extends KernelTestCase
{
    protected const NEWSLETTER_JSON_PATH = __DIR__ . '/../../data/';

    protected function tearDown(): void
    {
        $now = Carbon::now();
        unlink(sprintf('%s%s_newsletter.json', self::NEWSLETTER_JSON_PATH, $now->format('Y-m-d')));
        parent::tearDown();
    }

    public function test_execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:newspaper:handler');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        self::assertStringContainsString('Duration', $output);
        $this->assertEmailCount(1);
    }
}
