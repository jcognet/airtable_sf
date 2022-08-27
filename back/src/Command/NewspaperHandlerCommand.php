<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Mailer\ErrorSender;
use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewspaperHandlerCommand extends Command
{
    protected static $defaultName = 'app:newspaper:handler';

    private Manager $newsHandler;
    private string $environment;
    private ErrorSender $errorSender;

    public function __construct(
        string $name = null,
        Manager $newsHandler,
        string $environment,
        ErrorSender $errorSender
    ) {
        parent::__construct($name);

        $this->newsHandler = $newsHandler;
        $this->environment = $environment;
        $this->errorSender = $errorSender;
    }

    protected function configure(): void
    {
        $this->setDescription('Create a newsletter from data in airtable.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', self::$defaultName, $start->format('d/m/Y H:i')));

        try {
            $this->newsHandler->handle(Carbon::now());
        } catch (\Throwable $e) {
            $this->errorSender->send($e);

            if ($this->environment !== 'prod') {
                throw $e;
            }
        }

        $end = Carbon::now();
        $interval = $end->diffAsCarbonInterval($start);
        $output->writeln(sprintf('Duration: %s', $interval->forHumans()));

        return Command::SUCCESS;
    }
}
