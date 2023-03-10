<?php
declare(strict_types=1);

namespace App\Service\Export;

use App\Service\AirTable\Article\ALireClient;
use App\Service\AirTable\Article\ConceptClient;
use App\Service\AirTable\Article\ImageClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\AirTable\Book\BookClient;
use App\Service\AirTable\ToDo\ItemClient;
use App\Service\Google\ExportAirtableWriter;
use App\Service\Repository\Random\CurrencyRepository;
use App\Service\Repository\Random\GithubRepository;
use Carbon\Carbon;

class ExportToSpreadsheet
{
    public function __construct(
        private readonly ExportAirtableWriter $exportAirtableWriter,
        private readonly LuClient $luClient,
        private readonly ItemClient $itemClient,
        private readonly ALireClient $ALireClient,
        private readonly BookClient $bookClient,
        private readonly ImageClient $imageClient,
        private readonly GithubRepository $githubRepository,
        private readonly CurrencyRepository $currencyRepository,
        private readonly ConceptClient $conceptClient
    ) {
    }

    public function getData(): array
    {
        $currencies = $this->currencyRepository->getCurrencies();
        $nbArticleNotRead = count($this->ALireClient->findAll());
        $nbArticleNotConcept = count($this->luClient->findAll(['filterByFormula' => '{Conceptualisé} = 0']));
        $nbImageNotConcept = count($this->imageClient->findAll(['filterByFormula' => '{Conceptualisé} = 0']));
        $nbArticleNotReadAndNbArticleWithNoConcept = $nbArticleNotRead + $nbArticleNotConcept + $nbImageNotConcept;

        return [
            Carbon::now()->format('d/m/Y'),
            count($this->itemClient->findAll()),
            count($this->luClient->findAll()),
            $nbArticleNotRead,
            count($this->bookClient->findAll(['filterByFormula' => '{Status} = "A lire"'])),
            count($this->bookClient->findAll(['filterByFormula' => '{Status} = "Fini"'])),
            count($this->imageClient->findAll()),
            count($this->itemClient->findAll(['filterByFormula' => '{Etat} = "Done"'])),
            $this->githubRepository->getNbIssues(),
            $currencies[0]->getValue(),
            $currencies[1]->getValue(),
            $currencies[2]->getValue(),
            $currencies[3]->getValue(),
            $currencies[4]->getValue(),
            count($this->conceptClient->findAll()),
            $nbArticleNotConcept,
            $nbArticleNotReadAndNbArticleWithNoConcept,
            $nbImageNotConcept,
        ];
    }

    public function export(): int
    {
        return $this->exportAirtableWriter->write(
            [
                $this->getData(),
            ]
        );
    }
}
