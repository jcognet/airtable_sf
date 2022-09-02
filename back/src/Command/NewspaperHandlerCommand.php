<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Archive\DataInputOuputHandler;
use App\Service\Mailer\ErrorSender;
use App\Service\Mailer\NewspaperSender;
use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewspaperHandlerCommand extends Command
{
    protected static $defaultName = 'app:newspaper:handler';

    private string $environment;
    private ErrorSender $errorSender;
    private Manager $manager;
    private NewspaperSender $sender;
    private DataInputOuputHandler $dataInputOuputHandler;

    public function __construct(
        string $name = null,
        string $environment,
        ErrorSender $errorSender,
        Manager $manager,
        NewspaperSender $sender,
        DataInputOuputHandler $dataInputOuputHandler
    ) {
        parent::__construct($name);

        $this->environment = $environment;
        $this->errorSender = $errorSender;
        $this->manager = $manager;
        $this->sender = $sender;
        $this->dataInputOuputHandler = $dataInputOuputHandler;
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
            $newsLetter = $this->manager->get(Carbon::now());

            if (!$newsLetter->wasSent()) {
                $this->sender->send($newsLetter->getContent());
                $newsLetter->setWasSent(true);
                $this->dataInputOuputHandler->write(
                    $newsLetter
                );
            }
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
