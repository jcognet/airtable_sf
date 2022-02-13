<?php
declare(strict_types=1);

namespace App\ValueObject\NewsletterBlockManager;

use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\ImageManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Beer\GoodBeerBlockManager;
use App\Service\Block\Book\BookBlockManager;
use App\Service\Block\Book\BookListBlockManager;
use App\Service\Block\Google\DoneContentManager;
use App\Service\Block\Google\InProgressContentManager;
use App\Service\Block\Meteo\MeteoBlockManager;
use App\Service\Block\Random\InrManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\Random\RgsenManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\Service\Block\Twitter\BotDouxManager;

class ManagerType
{
    private const LIST_TYPE = [
        ImageManager::class,
        MeteoBlockManager::class,
        BookBlockManager::class,
        RandomPicBlockManager::class,
        GoodBeerBlockManager::class,
        LuBlockManager::class,
        BookListBlockManager::class,
        ItemBlockManager::class,
        ArticleListALireBlockManager::class,
        VideoBlockManager::class,
        BotDouxManager::class,
        InProgressContentManager::class,
        RgsenManager::class,
        DoneContentManager::class,
        InrManager::class,
    ];

    private string $type;

    public function __construct(string $type)
    {
        if (!in_array($type, self::LIST_TYPE, true)) {
            throw new \UnexpectedValueException(sprintf('Unknown manager Type: %s. (Allowed ones are: %s)', $type, implode(',', self::LIST_TYPE)));
        }

        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
