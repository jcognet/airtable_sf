<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\NewsletterBlockManager\BlockType;

class ArticleReadList extends AbstractArticleList
{
    public function getType(): BlockType
    {
        return BlockType::LIST_ARTICLE_READ_BLOCK;
    }
}
