<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Block\Article\ALireCreator;
use App\Service\Block\Article\LuCreator;
use App\Service\Block\Biere\GoodBiereCreator;
use App\Service\Block\Random\RandomPicCreator;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private Sender $sender;
    private GoodBiereCreator $biereCreator;
    private LuCreator $luCreator;
    private ALireCreator $ALireCreator;
    private RandomPicCreator $animalCreator;

    public function __construct(
        LuCreator $luCreator,
        ALireCreator $ALireCreator,
        GoodBiereCreator $biereCreator,
        RandomPicCreator $animalCreator,
        Sender $sender
    ) {
        $this->sender = $sender;
        $this->biereCreator = $biereCreator;
        $this->luCreator = $luCreator;
        $this->ALireCreator = $ALireCreator;
        $this->animalCreator = $animalCreator;
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
        $newspaper->addBlock($this->animalCreator->getContent());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
