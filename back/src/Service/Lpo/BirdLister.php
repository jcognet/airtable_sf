<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\ValueObject\Lpo\ImportedBird;
use Symfony\Component\Filesystem\Filesystem;

class BirdLister
{
    public function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @return ImportedBird[]
     */
    public function list(bool $onlyWithImage = false): ?array
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->config->getSavedBirdFileName())) {
            return null;
        }

        $data = json_decode(file_get_contents($this->config->getSavedBirdFileName()), true, 512, JSON_THROW_ON_ERROR);
        $birds = [];

        foreach ($data['data']['birds'] as $birdJson) {
            if (!$onlyWithImage || $birdJson['savedImgPath'] !== null) {
                $birds[] = new ImportedBird(
                    lpoId: $birdJson['lpoId'],
                    name: $birdJson['name'],
                    lpoUrl: $birdJson['lpoUrl'],
                    fullName: $birdJson['fullName'],
                    pdfUrl: $birdJson['pdfUrl'],
                    savedPdfPath: $birdJson['savedPdfPath'],
                    savedImgPath: $birdJson['savedImgPath']
                );
            }
        }

        return $birds;
    }
}
