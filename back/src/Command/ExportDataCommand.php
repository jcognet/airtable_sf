<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Export\ExportToSpreadsheet;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportDataCommand extends Command
{
    protected static $defaultName = 'app:export:spreadsheet';

    public function __construct(private readonly ExportToSpreadsheet $exportToSpreadsheet)
    {
    }

    protected function configure(): void
    {
        $this->setDescription('Export data in google spreadsheet.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $this->exportToSpreadsheet->export();

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
