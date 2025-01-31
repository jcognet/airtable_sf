<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

enum ArticleTypeEnum: string
{
    case PODCAST = 'Podcast';
    case VIDEO = 'Vidéo';
    case TEXTE = 'Texte';
    case LIVRE = 'Livre';
    case SITE_INTERNET = 'Site internet';
    case REPERTOIRE = 'Répertoire';
    case IMAGE = 'Image';
}
