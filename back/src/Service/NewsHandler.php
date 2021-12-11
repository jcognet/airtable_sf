<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Block\Article\ALireCreator;
use App\Service\Block\Article\LuCreator;
use App\Service\Block\Biere\GoodBiereCreator;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private Sender $sender;
    private GoodBiereCreator $biereCreator;
    private LuCreator $luCreator;
    private ALireCreator $ALireCreator;

    public function __construct(
        LuCreator $luCreator,
        ALireCreator $ALireCreator,
        GoodBiereCreator $biereCreator,
        Sender $sender
    ) {
        $this->sender = $sender;
        $this->biereCreator = $biereCreator;
        $this->luCreator = $luCreator;
        $this->ALireCreator = $ALireCreator;
    }

    public function handle(): void
    {
        $this->sendContent($this->createContent());
    }

    private function createContent(): Newspaper
    {
        $newspaper = new Newspaper();

        $newspaper->addBlock($this->luCreator->getContent());
        $newspaper->addBlock($this->ALireCreator->getContent());
        $newspaper->addBlock($this->biereCreator->getContent());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
