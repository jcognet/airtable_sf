<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Export\Exporter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:export:spreadsheet')]
class ExportDataCommand extends Command
{
    public function __construct(private readonly Exporter $exporter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Export data in google spreadsheet.')
            ->addOption('no_google_save', null, InputOption::VALUE_NONE, 'if given, the command will not update google.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $this->exporter->export(
            !$input->getOption('no_google_save')
        );

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
