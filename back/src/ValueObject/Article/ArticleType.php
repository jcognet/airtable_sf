<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class ArticleType
{
    final public const PODCAST = 'Podcast';
    final public const VIDEO = 'Vidéo';
    final public const TEXTE = 'Texte';
    final public const LIVRE = 'Livre';
    final public const SITE_INTERNET = 'Site internet';
    final public const REPERTOIRE = 'Répertoire';
    final public const IMAGE = 'Image';

    private const LIST_ARTICLE_TYPE = [
        self::PODCAST,
        self::VIDEO,
        self::TEXTE,
        self::LIVRE,
        self::SITE_INTERNET,
        self::REPERTOIRE,
        self::IMAGE,
    ];
    private readonly string $value;

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
