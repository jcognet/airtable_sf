<?php
declare(strict_types=1);

namespace App\Command\Children;

use App\Service\Repository\Children\ChildrenRepository;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:children:get')]
class GetChildrenCommand extends Command
{
    public function __construct(
        private readonly ChildrenRepository $childrenRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Read children.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        foreach ($this->childrenRepository->get() as $child) {
            $output->writeln(
                sprintf(
                    'First name: %s, Birth: %s',
                    $child->getFirstName(),
                    $child->getBirthDay()->format('d/m/Y')
                )
            );
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
