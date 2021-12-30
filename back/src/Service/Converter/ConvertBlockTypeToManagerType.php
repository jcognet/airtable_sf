<?php
declare(strict_types=1);

namespace App\Service\Converter;

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
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;

class ConvertBlockTypeToManagerType
{
    private const CONVERTER = [
        ImageManager::class => 'image',
        MeteoBlockManager::class => 'list_meteo',
        BookBlockManager::class => 'book',
        RandomPicBlockManager::class => 'image_url',
        GoodBiereBlockManager::class => 'list_biere',
        LuBlockManager::class => 'article',
        BookListBlockManager::class => 'list_book',
        ItemBlockManager::class => 'list_todo',
        ArticleListALireBlockManager::class => 'list_article',
        VideoBlockManager::class => 'video',
    ];

    public function convert(BlockType $blockType): ManagerType
    {
        $managerType = array_flip(self::CONVERTER)[$blockType->getType()];

        return new ManagerType($managerType);
    }
}
