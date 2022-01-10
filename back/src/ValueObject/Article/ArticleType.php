<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class ArticleType
{
    public const PODCAST = 'Podcast';
    public const VIDEO = 'Vidéo';
    public const TEXTE = 'Texte';
    public const LIVRE = 'Livre';
    public const SITE_INTERNET = 'Site internet';
    public const REPERTOIRE = 'Répertoire';
    public const IMAGE = 'Image';

    private const LIST_ARTICLE_TYPE = [
        self::PODCAST,
        self::VIDEO,
        self::TEXTE,
        self::LIVRE,
        self::SITE_INTERNET,
        self::REPERTOIRE,
        self::IMAGE,
    ];
    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::LIST_ARTICLE_TYPE, true)) {
            throw new \UnexpectedValueException(sprintf('Unknown article type: %s. (Allowed ones are: %s)', $value, implode(',', self::LIST_ARTICLE_TYPE)));
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
