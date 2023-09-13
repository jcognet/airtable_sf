<?php
declare(strict_types=1);

namespace App\Command\Baby;

use App\Service\Google\ExportNurseryWriter;
use App\Service\Google\GooglePlaceClient;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:baby:nursery:import')]
class ImportNurseryCommand extends Command
{
    public function __construct(
        private readonly GooglePlaceClient $googlePlaceClient,
        private readonly ExportNurseryWriter $exportNurseryWriter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import nursery to google spreadsheet file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        $places = $this->googlePlaceClient->import('crêche');
        $output->writeln(sprintf('Number of found places: %d', count($places)));
        $this->exportNurseryWriter->write($places);

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
