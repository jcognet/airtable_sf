<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\NewsHandler;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewspaperHandlerCommand extends Command
{
    protected static $defaultName = 'app:newspaper:handler';
    private NewsHandler $newsHandler;

    public function __construct(string $name = null, NewsHandler $newsHandler)
    {
        parent::__construct($name);

        $this->newsHandler = $newsHandler;
    }

    protected function configure(): void
    {
        $this->setDescription('Create a newsletter from data in airtable.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $this->newsHandler->handle();

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
