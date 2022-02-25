<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\Exception\MethodNotUsableException;
use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class InterestingTopic implements BlockInterface
{
    private string $title;

    public function __construct(
        string $title
    ) {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->getTitle();
    }

    public function getType(): BlockType
    {
        throw new MethodNotUsableException('Method getType from %s it not callable.', self::class);
    }
}
