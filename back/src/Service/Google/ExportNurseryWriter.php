<?php
declare(strict_types=1);

namespace App\Service\Google;

use App\ValueObject\Google\Place;

class ExportNurseryWriter
{
    public function __construct(
        private readonly string $spreadSheetNurseryId,
        private readonly GoogleClient $googleClient
    ) {}

    /**
     * @param Place[] $data
     */
    public function write(array $data): int
    {
        $dataArray = [];

        foreach ($data as $object) {
            $dataArray[] = array_values((array) $object);
        }

        $sheets = $this->googleClient->getCurrentSheets();
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $dataArray,
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];
        $result = $sheets->spreadsheets_values->append($this->spreadSheetNurseryId, 'A:F', $body, $params);

        return $result->getUpdates()->getUpdatedRows();
    }
}
