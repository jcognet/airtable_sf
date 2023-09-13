<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Picture\ZipAllPictureDirectory;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:zip:picture')]
class ZipPictureCommand extends Command
{
    public function __construct(private readonly ZipAllPictureDirectory $zipAllPictureDirectory)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Zip pictures in a directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        $this->zipAllPictureDirectory->zipAll();

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
