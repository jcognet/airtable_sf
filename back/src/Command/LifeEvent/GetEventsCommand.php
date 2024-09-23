<?php
declare(strict_types=1);

namespace App\Command\LifeEvent;

use App\Service\Repository\LifeEvent\LifeRepository;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:events:get')]
class GetEventsCommand extends Command
{
    public function __construct(
        private readonly LifeRepository $lifeRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Read events.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        foreach ($this->lifeRepository->get() as $event) {
            $output->writeln(
                sprintf(
                    'First name: %s, date: %s',
                    $event->getLabel(),
                    $event->getDate()->format('d/m/Y')
                )
            );
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
