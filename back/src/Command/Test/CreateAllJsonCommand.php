<?php
declare(strict_types=1);

namespace App\Command\Test;

use App\Service\Archive\DataInputOuputHandler;
use App\Service\NewsletterManager\NewspaperCreator;
use App\Service\NewsletterManager\NewspaperRenderer;
use App\ValueObject\Archive\NewsLetter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:create-json-all')]
class CreateAllJsonCommand extends Command
{
    private const LIST_CALL = [
        '2022-01-01' => 'createContent',
        '2022-01-02' => 'createContent',
        '2022-01-03' => 'createContent',
        '2022-01-04' => 'createAllContent',
    ];

    public function __construct(
        private readonly DataInputOuputHandler $dataInputOuputHandler,
        private readonly NewspaperCreator $creator,
        private readonly string $deployArchiveJsonPath,
        private readonly string $projectDir,
        private readonly NewspaperRenderer $newspaperRenderer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Create JSON data for all test blocks and copy it to the test dir.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        foreach (self::LIST_CALL as $dateTest => $function) {
            $output->writeln(sprintf('Create data test for %s with function %s.', $dateTest, $function));
            $date = Carbon::parse($dateTest);
            $newspaper = $this->creator->{$function}($date);
            $this->dataInputOuputHandler->write(
                new NewsLetter(
                    date: $date,
                    newsletterHtml: $this->newspaperRenderer->renderHtml($newspaper),
                    wasSent: false,
                    newspaper: $newspaper
                )
            );
            $from = sprintf('%s%s_newsletter.json', $this->deployArchiveJsonPath, $date->format('Y-m-d'));
            $to = sprintf('%s/tests/data/%s_newsletter.json', $this->projectDir, $date->format('Y-m-d'));
            $output->writeln(sprintf('Try to move from %s to %s for day %s.', $from, $to, $date->format('Y-m-d')));
            copy(
                $from,
                $to,
            );
            $this->newspaperRenderer->resetHtml();
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
