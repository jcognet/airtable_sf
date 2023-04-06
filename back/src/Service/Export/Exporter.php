<?php
declare(strict_types=1);

namespace App\Service\Export;

use App\Service\AirTable\Article\ALireClient;
use App\Service\AirTable\Article\ConceptClient;
use App\Service\AirTable\Article\ImageClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\AirTable\Book\BookClient;
use App\Service\AirTable\ToDo\ItemClient;
use App\Service\Archive\ExportWriterFetcher;
use App\Service\Google\ExportAirtableWriter;
use App\Service\Repository\Random\CurrencyRepository;
use App\Service\Repository\Random\GithubRepository;
use Carbon\Carbon;

class Exporter
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
        private readonly ConceptClient $conceptClient,
        private readonly ExportWriterFetcher $exportWriterFetcher
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
            'date' => Carbon::now()->format('d/m/Y'),
            'to_do_item_count' => count($this->itemClient->findAll()),
            'article_read_count' => count($this->luClient->findAll()),
            'article_not_read_count' => $nbArticleNotRead,
            'book_not_read_count' => count($this->bookClient->findAll(['filterByFormula' => '{Status} = "A lire"'])),
            'book_read_count' => count($this->bookClient->findAll(['filterByFormula' => '{Status} = "Fini"'])),
            'image_count' => count($this->imageClient->findAll()),
            'to_do_items_done_count' => count($this->itemClient->findAll(['filterByFormula' => '{Etat} = "Done"'])),
            'github_issues_count' => $this->githubRepository->getNbIssues(),
            $currencies[0]->getSymbol() => $currencies[0]->getValue(),
            $currencies[1]->getSymbol() => $currencies[1]->getValue(),
            $currencies[2]->getSymbol() => $currencies[2]->getValue(),
            $currencies[3]->getSymbol() => $currencies[3]->getValue(),
            $currencies[4]->getSymbol() => $currencies[4]->getValue(),
            'concept_count' => count($this->conceptClient->findAll()),
            'article_with_no_concept_count' => $nbArticleNotConcept,
            'article_image_no_concept_count' => $nbArticleNotReadAndNbArticleWithNoConcept,
            'image_no_councept_count' => $nbImageNotConcept,
        ];
    }

    public function export(bool $writeData): void
    {
        $data = $this->getData();
        $this->exportWriterFetcher->write($data, Carbon::now());

        if ($writeData) {
            $this->exportAirtableWriter->write(
                [
                    array_values($data),
                ]
            );
        }
    }
}
