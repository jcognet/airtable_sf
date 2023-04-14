<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Archive\NewsletterWriterFetcher;
use App\Service\Mailer\ErrorSender;
use App\Service\Mailer\NewsletterSender;
use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:newspaper:handler')]
class NewspaperHandlerCommand extends Command
{
    public function __construct(
        private readonly string $environment,
        private readonly ErrorSender $errorSender,
        private readonly Manager $manager,
        private readonly NewsletterSender $sender,
        private readonly NewsletterWriterFetcher $newsletterWriterFetcher
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Create a newsletter from data in airtable.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = Carbon::now();
        $output->writeln(sprintf('Start of command %s at %s', $this->getName(), $start->format('d/m/Y H:i')));

        try {
            $newsLetter = $this->manager->get(Carbon::now());

            if (!$newsLetter->wasSent()) {
                $this->sender->send($newsLetter->getNewsletterHtml());
                $newsLetter->setWasSent(true);
                $this->newsletterWriterFetcher->write(
                    $newsLetter
                );
            }
        } catch (\Throwable $e) {
            $output->write(sprintf('<error>Error: %s</error>', $e->getMessage()));
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
