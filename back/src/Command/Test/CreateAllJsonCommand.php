<?php
declare(strict_types=1);

namespace App\Command\Test;

use App\Service\Archive\DataInputOuputHandler;
use App\Service\NewsletterManager\NewspaperCreator;
use App\ValueObject\Archive\NewsLetter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:create-json-all')]
class CreateAllJsonCommand extends Command
{
    public function __construct(
        private readonly DataInputOuputHandler $dataInputOuputHandler,
        private readonly NewspaperCreator $creator,
        private readonly string $deployArchiveJsonPath,
        private readonly string $projectDir
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Create JSON data for all blocks and copy it to the test dir.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $newspaper = $this->creator->createAllContent();
        $this->dataInputOuputHandler->write(
            new NewsLetter(
                date: Carbon::parse('2022-01-04'),
                newsletterHtml: '',
                wasSent: false,
                newspaper: $newspaper
            )
        );

        $from = sprintf('%s2022-01-04_newsletter.json', $this->deployArchiveJsonPath);
        $to = sprintf('%s/tests/data/2022-01-04_newsletter.json', $this->projectDir);
        $output->writeln(sprintf('Try to move from %s to %s', $from, $to));
        copy(
            $from,
            $to,
        );

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
