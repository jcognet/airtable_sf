<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\AirTable\Article\ALireClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\AirTable\Biere\BiereClient;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private LuClient $luClient;
    private ALireClient $aLireClient;
    private Sender $sender;
    private BiereClient $biereClient;

    public function __construct(
        LuClient $luClient,
        ALireClient $aLireClient,
        BiereClient $biereClient,
        Sender $sender
    ) {
        $this->luClient = $luClient;
        $this->sender = $sender;
        $this->aLireClient = $aLireClient;
        $this->biereClient = $biereClient;
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
        $newspaper->addBlock($this->biereClient->fetchData());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
