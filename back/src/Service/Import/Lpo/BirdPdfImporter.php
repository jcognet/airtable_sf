<?php
declare(strict_types=1);

namespace App\Service\Import\Lpo;

use App\Service\Lpo\BirdListFetcher;
use App\Service\Lpo\BirdPdfSave;
use App\Service\Lpo\Config;
use App\Service\Lpo\PdfToJpegConverter;
use App\ValueObject\Lpo\ImportedBird;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class BirdPdfImporter
{
    public function __construct(
        private readonly BirdListFetcher $birdListFetcher,
        private readonly BirdPdfSave $birdPdfSave,
        private readonly Config $config,
        private readonly SerializerInterface $serializer,
        private readonly LoggerInterface $logger,
        private readonly PdfToJpegConverter $pdfToJpegConverter
    ) {}

    /**
     * @return ImportedBird[]
     */
    public function import(): array
    {
        $listAllBird = $this->birdListFetcher->fetch();
        $listBirdWithPdf = [];

        foreach ($listAllBird as $bird) {
            $this->birdPdfSave->save($bird);

            if ($bird->getPdfUrl()) {
                $this->createJpeg($bird);
                $listBirdWithPdf[] = $bird;
            }
        }

        $this->save($listBirdWithPdf);

        return $listBirdWithPdf;
    }

    private function createJpeg(ImportedBird $bird): void
    {
        $bird->setSavedImgPath(str_replace('pdf', 'jpg', (string) $bird->getSavedPdfPath()));
        $this->logger->info(
            sprintf(
                'PDF path: %s, JPG path: %s',
                $bird->getSavedPdfPath(),
                $bird->getSavedImgPath(),
            ),
            [$bird]
        );
        $this->pdfToJpegConverter->convert($bird);
    }

    private function save(array $birds): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->config->getSavedBirdFileName(),
            $this->serializer->serialize(
                [
                    'data' => [
                        'birds' => $birds,
                    ],
                    'metadata' => [
                        'created' => Carbon::now(),
                    ],
                ],
                'json'
            )
        );
    }
}
