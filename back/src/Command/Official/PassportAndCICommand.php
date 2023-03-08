<?php
declare(strict_types=1);

namespace App\Command\Official;

use App\Service\Archive\Cleaner;
use App\Service\Official\PassportRequester;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:official:passport')]
class PassportAndCICommand extends Command
{
    public function __construct(private readonly PassportRequester $passportRequester)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Get if a meeting for passport & CI is available..');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        $this->passportRequester->request();

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
