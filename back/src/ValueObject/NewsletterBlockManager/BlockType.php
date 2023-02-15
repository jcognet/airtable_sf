<?php
declare(strict_types=1);

namespace App\ValueObject\NewsletterBlockManager;

class BlockType
{
    final public const IMAGE_BLOCK = 'image';
    final public const LIST_METEO_BLOCK = 'list_meteo';
    final public const BOOK_BLOCK = 'book';
    final public const IMAGE_URL_BLOCK = 'image_url';
    final public const IMAGE_LIST_URL_BLOCK = 'list_image_url';
    final public const LIST_BEER__BLOCK = 'list_beer';
    final public const ARTICLE_BLOCK = 'article';
    final public const LIST_BOOK_BLOCK = 'list_book';
    final public const LIST_TODO_BLOCK = 'list_todo';
    final public const LIST_ARTICLE_BLOCK = 'list_article';
    final public const VIDEO_BLOCK = 'video';
    final public const BOT_DOUX_BLOCK = 'bot_doux';
    final public const IMAGE_GOOGLE_EXPORT_IN_PROGRESS_BLOCK = 'image_google_in_progess';
    final public const RGSEN_BLOCK = 'rgsen';
    final public const GOOD_PRACTICE_ORGANIZATION_BLOCK = 'good_practice_organization';
    final public const IMAGE_GOOGLE_EXPORT_DONE_BLOCK = 'image_google_done';
    final public const INR_TOOLS = 'list_inr_tool';
    final public const LIST_ARTICLE_READ_BLOCK = 'list_article_read';
    final public const LIST_ARTICLE_INTERESTING_TOPIC_BLOCK = 'list_interesting_topic';
    final public const CONCEPT_BLOCK = 'concept';
    final public const IMAGE_GOOGLE_EXPORT_CURRENCIES_BLOCK = 'image_google_currencies';
    final public const IMAGE_LIST_PICTURES = 'image_list_pictures';
    final public const BIRD = 'bird';
    final public const LIST_BIRD = 'list_bird';
    final public const SEE_AGAIN = 'see_again';

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
        self::BOT_DOUX_BLOCK,
        self::IMAGE_GOOGLE_EXPORT_IN_PROGRESS_BLOCK,
        self::RGSEN_BLOCK,
        self::GOOD_PRACTICE_ORGANIZATION_BLOCK,
        self::IMAGE_GOOGLE_EXPORT_DONE_BLOCK,
        self::INR_TOOLS,
        self::LIST_ARTICLE_READ_BLOCK,
        self::LIST_ARTICLE_INTERESTING_TOPIC_BLOCK,
        self::CONCEPT_BLOCK,
        self::IMAGE_GOOGLE_EXPORT_CURRENCIES_BLOCK,
        self::IMAGE_LIST_URL_BLOCK,
        self::IMAGE_LIST_PICTURES,
        self::BIRD,
        self::LIST_BIRD,
        self::SEE_AGAIN,
    ];

    private readonly string $type;

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
