<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Exception\Builder\UnknownArticleBuilderException;
use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Article\SujetRepository;
use App\ValueObject\Article\Article;
use App\ValueObject\Article\ArticleType;
use App\ValueObject\Article\Status;
use Carbon\Carbon;

abstract class AbstractArticleBuilder implements BuilderInterface
{
    private const TABLE_URL_LU = 'tblPLpYPyAOT2q13Q';
    private const TABLE_URL_TO_READ = 'tbla72IEwy6EYrX2I';

    public function __construct(
        private readonly SujetRepository $sujetRepository,
        private readonly string $airtableAppArticleId,
        private readonly UrlBuilder $urlBuilder
    ) {}

    public function build(array $data): Article
    {
        $sujets = [];

        if (isset($data['fields']['Sujet'])) {
            foreach ($data['fields']['Sujet'] as $sujetId) {
                $sujets[] = $this->sujetRepository->getById($sujetId);
            }
        }

        $status = null;
        if (isset($data['fields']['Status'])) {
            $status = new Status($data['fields']['Status']);
        }

        return new Article(
            $data['fields']['Titre'] ?? '',
            $data['fields']['body'] ?? $data['fields']['Citation'] ?? '',
            Carbon::parse($data['createdTime']),
            $sujets,
            $status,
            $data['fields']['URL'] ?? '',
            isset($data['fields']['Type']) ? new ArticleType($data['fields']['Type']) : null,
            $this->urlBuilder->build($this->airtableAppArticleId, $this->getTableURL(), $this->getViewUrl(), $data['id']),
            $data['fields']['Conceptualisé'] ?? false,
            $data['fields']['A revoir'] ?? false
        );
    }

    abstract public function getViewUrl(): string;

    private function getTableURL(): string
    {
        switch (static::class) {
            case ArticleToReadBuilder::class:
                return self::TABLE_URL_TO_READ;
            case ArticleReadBuilder::class:
                return self::TABLE_URL_LU;
        }

        throw new UnknownArticleBuilderException(
            sprintf(
                'Unknown class: %s, available are: %s',
                static::class,
                implode(
                    ', ',
                    [ArticleToReadBuilder::class, ArticleReadBuilder::class]
                )
            )
        );
    }
}
