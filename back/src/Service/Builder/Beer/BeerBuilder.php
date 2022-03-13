<?php
declare(strict_types=1);

namespace App\Service\Builder\Beer;

use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Beer\BeerTypeRepository;
use App\Service\Repository\Beer\BreweryRepository;
use App\ValueObject\Beer\Beer;
use Carbon\Carbon;

class BeerBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblB5GKFToPMdSrmI';
    private const VIEW_URL = 'viwxrWfKNzqZiKerj';

    private BreweryRepository $brasserieRepository;
    private BeerTypeRepository $beerTypeRepository;
    private string $airtableAppBiereId;

    public function __construct(
        BreweryRepository $brasserieRepository,
        BeerTypeRepository $beerTypeRepository,
        string $airtableAppBiereId
    ) {
        $this->brasserieRepository = $brasserieRepository;
        $this->beerTypeRepository = $beerTypeRepository;
        $this->airtableAppBiereId = $airtableAppBiereId;
    }

    public function build(array $data): Beer
    {
        $brasserie = null;

        if (isset($data['fields']['Brasserie'][0])) {
            $brasserie = $this->brasserieRepository->getById($data['fields']['Brasserie'][0]);
        }

        $beerType = null;
        if (isset($data['fields']['Type'][0])) {
            $beerType = $this->beerTypeRepository->getById($data['fields']['Type'][0]);
        }

        return new Beer(
            $data['fields']['Bière'] ?? null,
            $data['fields']['Notes'] ?? null,
            $brasserie,
            $data['fields']['Note'] ?? null,
            $data['fields']['IBU'] ?? null,
            $data['fields']['Photo'][0]['url'] ?? null,
            isset($data['fields']['Date de test']) ? Carbon::parse($data['fields']['Date de test']) : null,
            $beerType,
            $data['fields']['Degré alcool'] ?? null,
            sprintf('https://airtable.com/%s/%s/%s/%s', $this->airtableAppBiereId, self::TABLE_URL, self::VIEW_URL, $data['id'])
        );
    }
}
