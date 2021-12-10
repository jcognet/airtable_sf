<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\AirTable\ALireClient;
use App\Service\AirTable\LuClient;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private LuClient $luClient;
    private Sender $sender;
    private ALireClient $aLireClient;

    public function __construct(
        LuClient $luClient,
        ALireClient $aLireClient,
        Sender $sender
    ) {
        $this->luClient = $luClient;
        $this->sender = $sender;
        $this->aLireClient = $aLireClient;
    }

    public function handle(): void
    {
        $this->sendContent($this->createContent());
    }

    private function createContent(): Newspaper
    {
        $newspaper = new Newspaper();

        $newspaper->addBlock($this->luClient->fetchData());
        $newspaper->addBlock($this->aLireClient->fetchData());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
