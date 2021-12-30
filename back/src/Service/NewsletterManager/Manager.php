<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class Manager
{
    private Sender $sender;
    private ConfigSelector $configSelector;
    private ManagerContentFactory $managerContentFactory;

    public function __construct(
        Sender $sender,
        ConfigSelector $configSelector,
        ManagerContentFactory $managerContentFactory
    ) {
        $this->sender = $sender;
        $this->configSelector = $configSelector;
        $this->managerContentFactory = $managerContentFactory;
    }

    public function handle(Carbon $date): void
    {
        $this->sendContent($this->createContent($date));
    }

    public function createContent(Carbon $date): Newspaper
    {
        $listManager = $this->configSelector->getBlocks($date);
        $newpapers = new Newspaper($date);

        foreach ($listManager as $manager) {
            $newpapers->addBlock($this->managerContentFactory->getContent($manager->getType()));
        }

        return $newpapers;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
