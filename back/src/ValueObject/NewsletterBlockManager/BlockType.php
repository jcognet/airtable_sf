<?php
declare(strict_types=1);

namespace App\ValueObject\NewsletterBlockManager;

use App\Exception\NewsletterBlockManager\UnknownBlockTypeException;

enum BlockType: string
{
    case IMAGE_BLOCK = 'image';
    case LIST_METEO_BLOCK = 'list_meteo';
    case BOOK_BLOCK = 'book';
    case IMAGE_URL_BLOCK = 'image_url';
    case IMAGE_LIST_URL_BLOCK = 'list_image_url';
    case LIST_BEER_BLOCK = 'list_beer';
    case ARTICLE_BLOCK = 'article';
    case LIST_BOOK_BLOCK = 'list_book';
    case LIST_TODO_BLOCK = 'list_todo';
    case LIST_ARTICLE_BLOCK = 'list_article';
    case VIDEO_BLOCK = 'video';
    case BOT_DOUX_BLOCK = 'bot_doux';
    case IMAGE_GOOGLE_EXPORT_IN_PROGRESS_BLOCK = 'image_google_in_progess';
    case RGSEN_BLOCK = 'rgsen';
    case GOOD_PRACTICE_ORGANIZATION_BLOCK = 'good_practice_organization';
    case IMAGE_GOOGLE_EXPORT_DONE_BLOCK = 'image_google_done';
    case INR_TOOLS = 'list_inr_tool';
    case LIST_ARTICLE_READ_BLOCK = 'list_article_read';
    case LIST_ARTICLE_INTERESTING_TOPIC_BLOCK = 'list_interesting_topic';
    case CONCEPT_BLOCK = 'concept';
    case IMAGE_GOOGLE_EXPORT_CURRENCIES_BLOCK = 'image_google_currencies';
    case IMAGE_LIST_PICTURES = 'image_list_pictures';
    case BIRD = 'bird';
    case LIST_BIRD = 'list_bird';
    case SEE_AGAIN = 'see_again';
    case NEXT_RUNS = 'next_runs';

    public static function make(string $type): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return $case;
            }
        }

        throw new UnknownBlockTypeException(
            $type
        );
    }
}
