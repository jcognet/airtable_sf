<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\NewsletterBlockManager\BlockType;

class ArticleSeeAgainList extends AbstractArticleList
{
    public function getType(): BlockType
    {
        return BlockType::SEE_AGAIN;
    }
}
