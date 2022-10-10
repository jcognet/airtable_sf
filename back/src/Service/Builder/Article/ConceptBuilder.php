<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\AirTable\Article\ImageClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\Builder\BuilderInterface;
use App\ValueObject\Article\Concept;

class ConceptBuilder implements BuilderInterface
{
    public function __construct(private readonly LuClient $luClient, private readonly ImageClient $imageClient)
    {
    }

    public function build(array $data): Concept
    {
        $linkedContents = [];

        if (isset($data['fields']['Lu'])) {
            foreach ($data['fields']['Lu'] as $articleId) {
                $linkedContents[] = $this->luClient->getById($articleId);
            }
        }

        if (isset($data['fields']['Link'])) {
            foreach ($data['fields']['Link'] as $imageId) {
                $linkedContents[] = $this->imageClient->getById($imageId);
            }
        }

        $linkedContents = array_filter($linkedContents);

        return new Concept(
            $data['fields']['Concept'] ?? '',
            $data['fields']['Détail'] ?? '',
            $linkedContents
        );
    }
}