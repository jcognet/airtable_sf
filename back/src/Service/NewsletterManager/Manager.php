<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Mailer\Sender;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use App\ValueObject\Newspaper;
use Carbon\Carbon;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Manager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private Sender $sender;
    private ConfigSelector $configSelector;
    private ManagerContentFactory $managerContentFactory;
    private string $environment;

    public function __construct(
        Sender $sender,
        ConfigSelector $configSelector,
        ManagerContentFactory $managerContentFactory,
        string $environment
    ) {
        $this->sender = $sender;
        $this->configSelector = $configSelector;
        $this->managerContentFactory = $managerContentFactory;
        $this->environment = $environment;
    }

    public function handle(Carbon $date): void
    {
        $this->sendContent($this->createContent($date));
    }

    public function createContent(Carbon $date): Newspaper
    {
        return $this->createNewsPaper($this->configSelector->getBlocks($date), $date);
    }

    public function createAllContent(): Newspaper
    {
        return $this->createNewsPaper($this->configSelector->getAllBlocks(), Carbon::now());
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }

    /**
     * @param ManagerType[] $listManager
     */
    private function createNewsPaper(array $listManager, Carbon $date): Newspaper
    {
        $newpapers = new Newspaper($date);

        foreach ($listManager as $manager) {
            try {
                $newpapers->addBlock($this->managerContentFactory->getContent($manager->getType()));
            } catch (\Exception $e) {
                $this->logger->error(sprintf('Error with block %s: %s', $manager->getType(), $e->getMessage()), [
                    'exception' => [
                        'file' => $e->getFile(),
                        'code' => $e->getCode(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ],
                ]);

                if ($this->environment !== 'prod') {
                    throw $e;
                }
            }
        }

        return $newpapers;
    }
}
