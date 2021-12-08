<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\AirTable\LuClient;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private LuClient $luClient;
    private Sender $sender;

    public function __construct(
        LuClient $luClient,
        Sender $sender
    ) {
        $this->luClient = $luClient;
        $this->sender = $sender;
    }

    public function handle(): void
    {
        $this->sendContent($this->createContent());
    }

    private function createContent(): Newspaper
    {
        $newspaper = new Newspaper();

        $newspaper->addBlock($this->luClient->fetchData());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
