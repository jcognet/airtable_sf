<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\NewsletterBlockManager\BlockType;

class InterestingTopicList extends AbstractArticleList
{
    public function getType(): BlockType
    {
        return BlockType::LIST_ARTICLE_INTERESTING_TOPIC_BLOCK;
    }

    public function getContentRandomOrder(): array
    {
        $list = $this->getContent();
        shuffle($list);

        return $list;
    }
}
