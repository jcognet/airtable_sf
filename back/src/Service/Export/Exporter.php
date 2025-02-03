<?php
declare(strict_types=1);

namespace App\Service\Export;

use App\Service\AirTable\Article\ALireClient;
use App\Service\AirTable\Article\ConceptClient;
use App\Service\AirTable\Article\ImageClient;
use App\Service\AirTable\Article\InterestingTopicClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\AirTable\Book\BookClient;
use App\Service\AirTable\ToDo\ItemClient;
use App\Service\Archive\ExportWriterFetcher;
use App\Service\Google\ExportAirtableWriter;
use App\Service\Import\Airtable\Qcm\Question\Lister;
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
        private readonly ConceptClient $conceptClient,
        private readonly ExportWriterFetcher $exportWriterFetcher,
        private readonly InterestingTopicClient $interestingTopicClient,
        private readonly Lister $questionLister
    ) {}

    public function getData(): array
    {
        $nbArticleNotRead = count($this->ALireClient->findAll());
        $nbArticleNotConcept = count($this->luClient->findAll(['filterByFormula' => '{Conceptualisé} = 0']));
        $nbImageNotConcept = count($this->imageClient->findAll(['filterByFormula' => '{Conceptualisé} = 0']));
        $nbInterestingTopic = count($this->interestingTopicClient->findAll());
        $nbWaitingForAction = $nbArticleNotRead + $nbArticleNotConcept + $nbImageNotConcept + $nbInterestingTopic;

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
            'concept_count' => count($this->conceptClient->findAll()),
            'article_with_no_concept_count' => $nbArticleNotConcept,
            'waiting_for_action_count' => $nbWaitingForAction,
            'image_no_concept_count' => $nbImageNotConcept,
            'interesting_topic_count' => $nbInterestingTopic,
            'questions' => count((array) $this->questionLister->list()),
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
