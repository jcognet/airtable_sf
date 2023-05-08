<?php
declare(strict_types=1);

namespace App\Command\Airtable;

use App\Service\Import\Airtable\Qcm\Question\QcmImporter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:airtable:import')]
class ImportCommand extends Command
{
    public function __construct(private readonly QcmImporter $qcmImporter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import data from Airtable');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        $questions = $this->qcmImporter->import();
        $output->writeln(sprintf('Questions imported: %d', count($questions)));

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
