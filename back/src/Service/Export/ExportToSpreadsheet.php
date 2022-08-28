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
    private ExportAirtableWriter $exportAirtableWriter;
    private LuClient $luClient;
    private ItemClient $itemClient;
    private ALireClient $ALireClient;
    private BookClient $bookClient;
    private ImageClient $imageClient;
    private GithubRepository $githubRepository;
    private CurrencyRepository $currencyRepository;
    private ConceptClient $conceptClient;

    public function __construct(
        ExportAirtableWriter $exportAirtableWriter,
        LuClient $luClient,
        ItemClient $itemClient,
        ALireClient $ALireClient,
        BookClient $bookClient,
        ImageClient $imageClient,
        GithubRepository $githubRepository,
        CurrencyRepository $currencyRepository,
        ConceptClient $conceptClient
    ) {
        $this->exportAirtableWriter = $exportAirtableWriter;
        $this->luClient = $luClient;
        $this->itemClient = $itemClient;
        $this->ALireClient = $ALireClient;
        $this->bookClient = $bookClient;
        $this->imageClient = $imageClient;
        $this->githubRepository = $githubRepository;
        $this->currencyRepository = $currencyRepository;
        $this->conceptClient = $conceptClient;
    }

    public function getData(): array
    {
        $currencies = $this->currencyRepository->getCurrencies();

        return [
            Carbon::now()->format('d/m/Y'),
            count($this->itemClient->findAll()),
            count($this->luClient->findAll()),
            count($this->ALireClient->findAll()),
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
            count($this->luClient->findAll(['filterByFormula' => '{Conceptualisé} = 0'])),
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
