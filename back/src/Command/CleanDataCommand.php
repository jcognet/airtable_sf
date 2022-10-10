<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Archive\Cleaner;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:newspaper:clean')]
class CleanDataCommand extends Command
{
    public function __construct(private readonly Cleaner $cleaner)
    {
        parent::__construct();
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
