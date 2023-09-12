<?php
declare(strict_types=1);

namespace App\ValueObject\NewsletterBlockManager;

use App\Exception\NewsletterBlockManager\UnknownManagerTypeException;
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
        InProgressContentManager::class,
        RgesnManager::class,
        DoneContentManager::class,
        InrManager::class,
        ArticleReadListBlockManager::class,
        GoodPracticeOrganizationManager::class,
        InterestingTopicListBlockManager::class,
        ConceptManager::class,
        CurrenciesManager::class,
        PictureManager::class,
        BirdManager::class,
        ListBirdManager::class,
        ArticleSeeAgainListBlockManager::class,
        NextRunBlockManager::class,
        ImageStatementManager::class,
        Inr491Manager::class,
        QuestionManager::class,
    ];

    private readonly string $type;

    public function __construct(string $type)
    {
        if (!in_array($type, self::LIST_TYPE, true)) {
            throw new UnknownManagerTypeException($type, self::LIST_TYPE);
        }

        $this->type = $type;
    }

    public static function getListType(): array
    {
        return self::LIST_TYPE;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
