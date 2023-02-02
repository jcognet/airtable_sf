<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\ValueObject\Lpo\ImportedBird;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class BirdPdfImporter
{
    public function __construct(
        private readonly BirdListFetcher $birdListFetcher,
        private readonly BirdPdfSave $birdPdfSave,
        private readonly string $birdPath,
        private readonly SerializerInterface $serializer
    ) {
    }

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
                $listBirdWithPdf[] = $bird;
            }
        }

        $this->createJpeg();
        $this->save($listBirdWithPdf);

        return $listBirdWithPdf;
    }

    private function createJpeg(): void
    {
        // $this->pdfToJpegConverter->convert($bird);
    }

    private function save(array $birds): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            sprintf('%s%s', $this->birdPath, 'birds.json'),
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
