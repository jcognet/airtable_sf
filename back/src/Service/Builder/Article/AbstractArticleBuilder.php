<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Article\SujetRepository;
use App\ValueObject\Article\Article;
use App\ValueObject\Article\ArticleType;
use App\ValueObject\Article\Status;
use Carbon\Carbon;

abstract class AbstractArticleBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblPLpYPyAOT2q13Q';

    public function __construct(
        private readonly SujetRepository $sujetRepository,
        private readonly string $airtableAppArticleId,
        private readonly UrlBuilder $urlBuilder
    ) {
    }

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
            $this->urlBuilder->build($this->airtableAppArticleId, self::TABLE_URL, $this->getViewUrl(), $data['id']),
            $data['fields']['Conceptualisé'] ?? false,
            $data['fields']['A revoir'] ?? false
        );
    }

    abstract public function getViewUrl(): string;
}
