<?php
declare(strict_types=1);

namespace App\Service\Export;

use App\Service\AirTable\Article\ALireClient;
use App\Service\AirTable\Article\ImageClient;
use App\Service\AirTable\Article\LuClient;
use App\Service\AirTable\Book\BookClient;
use App\Service\AirTable\ToDo\ItemClient;
use App\Service\Google\ExportAirtableWriter;
use Carbon\Carbon;

class ExportToSpreadsheet
{
    private ExportAirtableWriter $exportAirtableWriter;
    private LuClient $luClient;
    private ItemClient $itemClient;
    private ALireClient $ALireClient;
    private BookClient $bookClient;
    private ImageClient $imageClient;

    public function __construct(
        ExportAirtableWriter $exportAirtableWriter,
        LuClient $luClient,
        ItemClient $itemClient,
        ALireClient $ALireClient,
        BookClient $bookClient,
        ImageClient $imageClient
    ) {
        $this->exportAirtableWriter = $exportAirtableWriter;
        $this->luClient = $luClient;
        $this->itemClient = $itemClient;
        $this->ALireClient = $ALireClient;
        $this->bookClient = $bookClient;
        $this->imageClient = $imageClient;
    }

    public function export(): int
    {
        return $this->exportAirtableWriter->write(
            [
                [
                    Carbon::now()->format('d/m/Y'),
                    count($this->itemClient->findAll()),
                    count($this->luClient->findAll()),
                    count($this->ALireClient->findAll()),
                    count($this->bookClient->findAll(['filterByFormula' => '{Status} = "A lire"'])),
                    count($this->bookClient->findAll(['filterByFormula' => '{Status} = "Fini"'])),
                    count($this->imageClient->findAll()),
                    count($this->itemClient->findAll(['filterByFormula' => '{Etat} = "Done"'])),
                ],
            ]
        );
    }
}
