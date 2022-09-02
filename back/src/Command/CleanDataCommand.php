<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Archive\Cleaner;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanDataCommand extends Command
{
    protected static $defaultName = 'app:newspaper:clean';
    private Cleaner $cleaner;

    public function __construct(
        string $name = null,
        Cleaner $cleaner
    ) {
        parent::__construct($name);

        $this->cleaner = $cleaner;
    }

    protected function configure(): void
    {
        $this->setDescription('Remove old data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $from = Carbon::now()->subMonth();
        $output->writeln(sprintf('Remove file from %s', $from->format('d/m/Y')));

        $nb = $this->cleaner->clean($from);

        $output->writeln(sprintf('Number of files removed: %d', $nb));

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
