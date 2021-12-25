<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\ImageManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Biere\GoodBiereBlockManager;
use App\Service\Block\Book\BookListBlockManager;
use App\Service\Block\Meteo\MeteoBlockManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class WeekManager implements NewsletterManagerInterface
{
    private GoodBiereBlockManager $goodBiereBlockManager;
    private LuBlockManager $luBlockManager;
    private ArticleListALireBlockManager $articleListALireBlockManager;
    private RandomPicBlockManager $randomPicBlockManager;
    private VideoBlockManager $videoBlockManager;
    private ItemBlockManager $itemBlockManager;
    private ImageManager $imageManager;
    private MeteoBlockManager $meteoBlockManager;
    private BookListBlockManager $bookBlockManager;

    public function __construct(
        LuBlockManager $luCreator,
        ArticleListALireBlockManager $listALireBlockManager,
        GoodBiereBlockManager $goodBiereBlockManager,
        RandomPicBlockManager $randomPicBlockManager,
        VideoBlockManager $videoBlockManager,
        ItemBlockManager $itemBlockManager,
        ImageManager $imageManager,
        BookListBlockManager $bookBlockManager,
        MeteoBlockManager $meteoBlockManager
    )
    {
        $this->goodBiereBlockManager = $goodBiereBlockManager;
        $this->luBlockManager = $luCreator;
        $this->articleListALireBlockManager = $listALireBlockManager;
        $this->randomPicBlockManager = $randomPicBlockManager;
        $this->videoBlockManager = $videoBlockManager;
        $this->itemBlockManager = $itemBlockManager;
        $this->imageManager = $imageManager;
        $this->meteoBlockManager = $meteoBlockManager;
        $this->bookBlockManager = $bookBlockManager;
    }

    public function createNewsletter(Carbon $date): Newspaper
    {
        return $this->createContent($date);
    }

    private function createContent(Carbon $date): Newspaper
    {
        $newspaper = new Newspaper($date);

        $newspaper->addBlock($this->luBlockManager->getContent());
        $newspaper->addBlock($this->imageManager->getContent());
        $newspaper->addBlock($this->bookBlockManager->getContent());
        $newspaper->addBlock($this->meteoBlockManager->getContent());
        $newspaper->addBlock($this->itemBlockManager->getContent());
        $newspaper->addBlock($this->randomPicBlockManager->getContent());
        $newspaper->addBlock($this->articleListALireBlockManager->getContent());
        $newspaper->addBlock($this->videoBlockManager->getContent());
        $newspaper->addBlock($this->goodBiereBlockManager->getContent());

        return $newspaper;
    }
}
