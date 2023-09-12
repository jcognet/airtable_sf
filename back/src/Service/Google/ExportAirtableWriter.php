<?php
declare(strict_types=1);

namespace App\Service\Google;

class ExportAirtableWriter
{
    public function __construct(
        private readonly string $spreadSheetAirtableId,
        private readonly GoogleClient $googleClient
    ) {}

    public function write(array $data): int
    {
        $sheets = $this->googleClient->getCurrentSheets();

        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data,
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $result = $sheets->spreadsheets_values->append($this->spreadSheetAirtableId, 'A:F', $body, $params);

        return $result->getUpdates()->getUpdatedRows();
    }
}
