<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\ValueObject\Lpo\ImportedBird;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BirdListFetcher
{
    public function __construct(private readonly HttpClientInterface $lpoClient)
    {
    }

    /**
     * @return ImportedBird[]
     */
    public function fetch(): array
    {
        $listBirdJSHtml = [];
        // No crawlers there because the node list is empty... Bad HTML ? :/
        preg_match(
            '#var species_db = new Array\(([\s\S]*)\);#',
            $this->lpoClient->request('GET', '?m_id=15')->getContent(),
            $listBirdJSHtml
        );

        $listBird = [];
        foreach (explode(',', $listBirdJSHtml[1]) as $listBirdJS) {
            $cleanData = explode('@', trim($listBirdJS));
            $listBird[] = new ImportedBird(
                lpoId: (int) str_replace('"', '', $cleanData[0]),
                name: ucfirst(trim(str_replace('"', '', $cleanData[1])))
            );
        }

        return $listBird;
    }
}
