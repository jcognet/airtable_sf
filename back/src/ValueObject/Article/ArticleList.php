<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\NewsletterBlockManager\BlockType;

class ArticleList extends AbstractArticleList
{
    public function getType(): BlockType
    {
        return BlockType::LIST_ARTICLE_BLOCK;
    }
}
