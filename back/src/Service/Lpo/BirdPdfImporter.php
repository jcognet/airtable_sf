<?php
declare(strict_types=1);

namespace App\Service\Lpo;

class BirdPdfImporter
{
    public function __construct(
        private readonly BirdListFetcher $birdListFetcher,
        private readonly BirdPdfSave $birdPdfSave
    ) {
    }

    public function import(): array
    {
        $listAllBird = $this->birdListFetcher->fetch();
        $listBirdWithPdf = [];

        foreach ($listAllBird as $bird) {
            $this->birdPdfSave->save($bird);

            if ($bird->getPdfUrl()) {
                $listBirdWithPdf[] = $bird;
            }
        }

        return $listBirdWithPdf;
    }
}
