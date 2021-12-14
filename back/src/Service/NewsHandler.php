<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Biere\GoodBiereBlockManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;

class NewsHandler
{
    private Sender $sender;
    private GoodBiereBlockManager $goodBiereBlockManager;
    private LuBlockManager $luBlockManager;
    private ArticleListALireBlockManager $articleListALireBlockManager;
    private RandomPicBlockManager $randomPicBlockManager;
    private VideoBlockManager $videoBlockManager;
    private ItemBlockManager $itemBlockManager;

    public function __construct(
        LuBlockManager $luCreator,
        ArticleListALireBlockManager $listALireBlockManager,
        GoodBiereBlockManager $goodBiereBlockManager,
        RandomPicBlockManager $randomPicBlockManager,
        VideoBlockManager $videoBlockManager,
        ItemBlockManager $itemBlockManager,
        Sender $sender
    )
    {
        $this->sender = $sender;
        $this->goodBiereBlockManager = $goodBiereBlockManager;
        $this->luBlockManager = $luCreator;
        $this->articleListALireBlockManager = $listALireBlockManager;
        $this->randomPicBlockManager = $randomPicBlockManager;
        $this->videoBlockManager = $videoBlockManager;
        $this->itemBlockManager = $itemBlockManager;
    }

    public function handle(): void
    {
        $this->sendContent($this->createContent());
    }

    public function createContent(): Newspaper
    {
        $newspaper = new Newspaper();

        $newspaper->addBlock($this->luBlockManager->getContent());
        $newspaper->addBlock($this->itemBlockManager->getContent());
        $newspaper->addBlock($this->articleListALireBlockManager->getContent());
        $newspaper->addBlock($this->videoBlockManager->getContent());
        $newspaper->addBlock($this->goodBiereBlockManager->getContent());
        $newspaper->addBlock($this->randomPicBlockManager->getContent());

        return $newspaper;
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
