<?php
declare(strict_types=1);

namespace App\Command\Lpo;

use App\Service\Lpo\BirdPdfImporter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:lpo:pdf:fetch')]
class LpoPdfFetchCommand extends Command
{
    public function __construct(private readonly BirdPdfImporter $birdPdfImporter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Get PDF file from LPO.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $birds = $this->birdPdfImporter->import();

        $output->writeln(sprintf('Number of found birds: %d', count($birds)));

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
