<?php
declare(strict_types=1);

namespace App\Service\Builder\Biere;

use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Biere\BiereTypeRepository;
use App\Service\Repository\Biere\BrasserieRepository;
use App\ValueObject\Biere\Biere;
use Carbon\Carbon;

class BiereBuilder implements BuilderInterface
{
    private BrasserieRepository $brasserieRepository;
    private BiereTypeRepository $biereTypeRepository;

    public function __construct(
        BrasserieRepository $brasserieRepository,
        BiereTypeRepository $biereTypeRepository
    ) {
        $this->brasserieRepository = $brasserieRepository;
        $this->biereTypeRepository = $biereTypeRepository;
    }

    public function build(array $data): Biere
    {
        $brasserie = null;

        if (isset($data['fields']['Brasserie'][0])) {
            $brasserie = $this->brasserieRepository->getById($data['fields']['Brasserie'][0]);
        }

        $biereType = null;
        if (isset($data['fields']['Type'][0])) {
            $biereType = $this->biereTypeRepository->getById($data['fields']['Type'][0]);
        }

        return new Biere(
            $data['fields']['Bière'] ?? null,
            $data['fields']['Notes'] ?? null,
            $brasserie,
            $data['fields']['Note'] ?? null,
            $data['fields']['IBU'] ?? null,
            $data['fields']['Photo'][0]['url'] ?? null,
            isset($data['fields']['Date de test']) ? Carbon::parse($data['fields']['Date de test']) : null,
            $biereType,
            $data['fields']['Degré alcool'] ?? null
        );
    }
}
