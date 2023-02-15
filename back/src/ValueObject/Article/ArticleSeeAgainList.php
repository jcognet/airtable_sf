<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ArticleSeeAgainList extends AbstractArticleList implements BlockInterface
{
    public function getType(): BlockType
    {
        return new BlockType(BlockType::SEE_AGAIN);
    }
}
