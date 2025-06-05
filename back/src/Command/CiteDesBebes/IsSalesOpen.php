<?php
declare(strict_types=1);

namespace App\Command\CiteDesBebes;

use App\Service\CiteDesBebes\Alerter;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:cite_des_bebes:is-open')]
class IsSalesOpen extends Command
{
    public function __construct(
        private readonly Alerter $alerter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Query Cité des bébés to see if sales are open.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        if ($this->alerter->alert()) {
            $output->writeln('Email envoyé ! ');
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
