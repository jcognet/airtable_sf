<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\ImageManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Biere\GoodBiereBlockManager;
use App\Service\Block\Book\BookBlockManager;
use App\Service\Block\Book\BookListBlockManager;
use App\Service\Block\Meteo\MeteoBlockManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class SundayManager implements NewsletterManagerInterface
{
    private GoodBiereBlockManager $goodBiereBlockManager;
    private RandomPicBlockManager $randomPicBlockManager;
    private ImageManager $imageManager;
    private BookBlockManager $bookBlockManager;
    private MeteoBlockManager $meteoBlockManager;
    private ItemBlockManager $itemBlockManager;

    public function __construct(
        GoodBiereBlockManager $goodBiereBlockManager,
        RandomPicBlockManager $randomPicBlockManager,
        ImageManager $imageManager,
        BookBlockManager $bookBlockManager,
        MeteoBlockManager $meteoBlockManager,
        ItemBlockManager $itemBlockManager
    ) {
        $this->goodBiereBlockManager = $goodBiereBlockManager;
        $this->randomPicBlockManager = $randomPicBlockManager;
        $this->imageManager = $imageManager;
        $this->bookBlockManager = $bookBlockManager;
        $this->meteoBlockManager = $meteoBlockManager;
        $this->itemBlockManager = $itemBlockManager;
    }

    public function createNewsletter(Carbon $date): Newspaper
    {
        return $this->createContent($date);
    }

    private function createContent(Carbon $date): Newspaper
    {
        $newspaper = new Newspaper($date);

        $newspaper->addBlock($this->imageManager->getContent());
        $newspaper->addBlock($this->meteoBlockManager->getContent());
        $newspaper->addBlock($this->itemBlockManager->getContent());
        $newspaper->addBlock($this->bookBlockManager->getContent());
        $newspaper->addBlock($this->randomPicBlockManager->getContent());
        $newspaper->addBlock($this->goodBiereBlockManager->getContent());

        return $newspaper;
    }
}
