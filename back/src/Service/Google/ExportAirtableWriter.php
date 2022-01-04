<?php
declare(strict_types=1);

namespace App\Service\Google;

class ExportAirtableWriter
{
    private string $spreadSheetId;
    private GoogleClient $googleClient;

    public function __construct(
        string $spreadSheetAirtableId,
        GoogleClient $googleClient
    ) {
        $this->spreadSheetId = $spreadSheetAirtableId;
        $this->googleClient = $googleClient;
    }

    public function write(array $data): int
    {
        $sheets = $this->googleClient->getCurrentSheets();

        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data,
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $result = $sheets->spreadsheets_values->append($this->spreadSheetId, 'A:F', $body, $params);

        return $result->getUpdates()->getUpdatedRows();
    }
}
