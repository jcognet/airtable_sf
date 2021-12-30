<?php
declare(strict_types=1);

namespace App\ValueObject\NewsletterBlockManager;

class BlockType
{
    public const IMAGE_BLOCK = 'image';
    public const LIST_METEO_BLOCK = 'list_meteo';
    public const BOOK_BLOCK = 'book';
    public const IMAGE_URL_BLOCK = 'image_url';
    public const LIST_BEER__BLOCK = 'list_biere';
    public const ARTICLE_BLOCK = 'article';
    public const LIST_BOOK_BLOCK = 'list_book';
    public const LIST_TODO_BLOCK = 'list_todo';
    public const LIST_ARTICLE_BLOCK = 'list_article';
    public const VIDEO_BLOCK = 'video';

    private const LIST_TYPE = [
        self::IMAGE_BLOCK,
        self::LIST_METEO_BLOCK,
        self::BOOK_BLOCK,
        self::IMAGE_URL_BLOCK,
        self::LIST_BEER__BLOCK,
        self::ARTICLE_BLOCK,
        self::LIST_BOOK_BLOCK,
        self::LIST_TODO_BLOCK,
        self::LIST_ARTICLE_BLOCK,
        self::VIDEO_BLOCK,
    ];

    private string $type;

    public function __construct(string $type)
    {
        if (!in_array($type, self::LIST_TYPE, true)) {
            throw new \UnexpectedValueException(sprintf('Unknown block Type: %s. (Allowed ones are: %s)', $type, implode(',', self::LIST_TYPE)));
        }

        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}