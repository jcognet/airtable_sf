<?php
declare(strict_types=1);

namespace App\Service\Converter;

use App\Exception\NewsletterBlockManager\UnknownConvertBlockTypeToManagerTypeException;
use App\Service\Alert\AlertManager;
use App\Service\Block\Article\ArticleListALireBlockManager;
use App\Service\Block\Article\ArticleReadListBlockManager;
use App\Service\Block\Article\ArticleSeeAgainListBlockManager;
use App\Service\Block\Article\ConceptManager;
use App\Service\Block\Article\ImageManager;
use App\Service\Block\Article\InterestingTopicListBlockManager;
use App\Service\Block\Article\LuBlockManager;
use App\Service\Block\Article\VideoBlockManager;
use App\Service\Block\Beer\GoodBeerBlockManager;
use App\Service\Block\Book\BookBlockManager;
use App\Service\Block\Book\BookListBlockManager;
use App\Service\Block\Google\CurrenciesManager;
use App\Service\Block\Google\DoneContentManager;
use App\Service\Block\Google\InProgressContentManager;
use App\Service\Block\Lpo\BirdManager;
use App\Service\Block\Lpo\ImageStatementManager;
use App\Service\Block\Lpo\ListBirdManager;
use App\Service\Block\Meteo\MeteoBlockManager;
use App\Service\Block\Picture\PictureManager;
use App\Service\Block\Question\QuestionManager;
use App\Service\Block\Random\GoodPracticeOrganizationManager;
use App\Service\Block\Random\Inr491Manager;
use App\Service\Block\Random\InrManager;
use App\Service\Block\Random\RandomPicBlockManager;
use App\Service\Block\Random\RgesnManager;
use App\Service\Block\Run\NextRunBlockManager;
use App\Service\Block\ToDo\ItemBlockManager;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;

class ConvertBlockTypeToManagerType
{
    private const CONVERTER = [
        ImageManager::class => BlockType::IMAGE_BLOCK,
        MeteoBlockManager::class => BlockType::LIST_METEO_BLOCK,
        BookBlockManager::class => BlockType::BOOK_BLOCK,
        RandomPicBlockManager::class => BlockType::IMAGE_URL_BLOCK,
        GoodBeerBlockManager::class => BlockType::LIST_BEER_BLOCK,
        LuBlockManager::class => BlockType::ARTICLE_BLOCK,
        BookListBlockManager::class => BlockType::LIST_BOOK_BLOCK,
        ItemBlockManager::class => BlockType::LIST_TODO_BLOCK,
        ArticleListALireBlockManager::class => BlockType::LIST_ARTICLE_BLOCK,
        VideoBlockManager::class => BlockType::VIDEO_BLOCK,
        InProgressContentManager::class => BlockType::IMAGE_GOOGLE_EXPORT_IN_PROGRESS_BLOCK,
        RgesnManager::class => BlockType::RGESN_BLOCK,
        GoodPracticeOrganizationManager::class => BlockType::GOOD_PRACTICE_ORGANIZATION_BLOCK,
        DoneContentManager::class => BlockType::IMAGE_GOOGLE_EXPORT_DONE_BLOCK,
        InrManager::class => BlockType::INR_TOOLS,
        ArticleReadListBlockManager::class => BlockType::LIST_ARTICLE_READ_BLOCK,
        InterestingTopicListBlockManager::class => BlockType::LIST_ARTICLE_INTERESTING_TOPIC_BLOCK,
        ConceptManager::class => BlockType::CONCEPT_BLOCK,
        CurrenciesManager::class => BlockType::IMAGE_GOOGLE_EXPORT_CURRENCIES_BLOCK,
        PictureManager::class => BlockType::IMAGE_LIST_PICTURES,
        BirdManager::class => BlockType::BIRD,
        ListBirdManager::class => BlockType::LIST_BIRD,
        ArticleSeeAgainListBlockManager::class => BlockType::SEE_AGAIN,
        NextRunBlockManager::class => BlockType::NEXT_RUNS,
        ImageStatementManager::class => BlockType::BIRD_STATEMENT,
        Inr491Manager::class => BlockType::INR_491,
        QuestionManager::class => BlockType::QUIZ,
        AlertManager::class => BlockType::LIST_ALERT,
    ];

    public function convert(BlockType $blockType): ManagerType
    {
        foreach (self::CONVERTER as $manager => $block) {
            if ($block === $blockType) {
                return new ManagerType($manager);
            }
        }

        throw new UnknownConvertBlockTypeToManagerTypeException($blockType, self::CONVERTER);
    }

    public function reverseConvert(ManagerType $managerType): BlockType
    {
        return self::CONVERTER[$managerType->getType()];
    }
}
