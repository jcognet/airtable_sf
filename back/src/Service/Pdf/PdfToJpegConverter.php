<?php
declare(strict_types=1);

namespace App\Service\Pdf;

class PdfToJpegConverter
{
    public function __construct(private readonly string $pdfApiKey) {}

    public function convert(string $pathPdf, string $pathJpg): void
    {
        $fileHandle = fopen($pathJpg, 'w+');
        $curl = curl_init();
        $instructions = '{
  "parts": [
    {
      "file": "document"
    }
  ],
  "output": {
    "type": "image",
    "format": "jpg",
    "dpi": 150
  }
}';
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.pspdfkit.com/build',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_POSTFIELDS => [
                'instructions' => $instructions,
                'document' => new \CURLFile($pathPdf),
            ],
            CURLOPT_HTTPHEADER => [
                sprintf('Authorization: Bearer %s', $this->pdfApiKey),
            ],
            CURLOPT_FILE => $fileHandle,
        ]);
        curl_exec($curl);
        curl_close($curl);
        fclose($fileHandle);
    }
}
