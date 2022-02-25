<?php
declare(strict_types=1);

namespace App\Service\Converter;

use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\ArticleReadListBlockManager;
use App\Service\Block\Article\ImageManager;
use App\Service\Block\Article\InterestingTopicListBlockManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Beer\GoodBeerBlockManager;
use App\Service\Block\Book\BookBlockManager;
use App\Service\Block\Book\BookListBlockManager;
use App\Service\Block\Google\DoneContentManager;
use App\Service\Block\Google\InProgressContentManager;
use App\Service\Block\Meteo\MeteoBlockManager;
use App\Service\Block\Random\GoodPracticeOrganizationManager;
use App\Service\Block\Random\InrManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\Random\RgsenManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\Service\Block\Twitter\BotDouxManager;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;

class ConvertBlockTypeToManagerType
{
    private const CONVERTER = [
        ImageManager::class => BlockType::IMAGE_BLOCK,
        MeteoBlockManager::class => BlockType::LIST_METEO_BLOCK,
        BookBlockManager::class => BlockType::BOOK_BLOCK,
        RandomPicBlockManager::class => BlockType::IMAGE_URL_BLOCK,
        GoodBeerBlockManager::class => BlockType::LIST_BEER__BLOCK,
        LuBlockManager::class => BlockType::ARTICLE_BLOCK,
        BookListBlockManager::class => BlockType::LIST_BOOK_BLOCK,
        ItemBlockManager::class => BlockType::LIST_TODO_BLOCK,
        ArticleListALireBlockManager::class => BlockType::LIST_ARTICLE_BLOCK,
        VideoBlockManager::class => BlockType::VIDEO_BLOCK,
        BotDouxManager::class => BlockType::BOT_DOUX_BLOCK,
        InProgressContentManager::class => BlockType::IMAGE_GOOGLE_EXPORT_IN_PROGRESS_BLOCK,
        RgsenManager::class => BlockType::RGSEN_BLOCK,
        GoodPracticeOrganizationManager::class => BlockType::GOOD_PRACTICE_ORGANIZATION_BLOCK,
        DoneContentManager::class => BlockType::IMAGE_GOOGLE_EXPORT_DONE_BLOCK,
        InrManager::class => BlockType::INR_TOOLS,
        ArticleReadListBlockManager::class => BlockType::LIST_ARTICLE_READ_BLOCK,
        InterestingTopicListBlockManager::class => BlockType::LIST_ARTICLE_INTERESTING_TOPIC_BLOCK,
    ];

    public function convert(BlockType $blockType): ManagerType
    {
        $managerType = array_flip(self::CONVERTER)[$blockType->getType()];

        return new ManagerType($managerType);
    }
}
