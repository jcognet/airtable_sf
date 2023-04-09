<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Contract\CleanerInterface;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:newspaper:clean')]
class CleanDataCommand extends Command
{
    /**
     * @param CleanerInterface[] $listCleaners
     */
    public function __construct(private readonly iterable $listCleaners)
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
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        $from = Carbon::now()->subMonth();
        $output->writeln(sprintf('Remove file from %s', $from->format('d/m/Y')));

        foreach ($this->listCleaners as $cleaner) {
            $nb = $cleaner->clean($from);
            $output->writeln(
                sprintf(
                    'Number of files removed by %s: %d',
                    $cleaner::class,
                    $nb
                )
            );
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
