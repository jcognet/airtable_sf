<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\Service\FileNameGenerator;
use App\Service\Pdf\PdfToJpegConverter as PdfConverter;
use App\ValueObject\Lpo\ImportedBird;

class PdfToJpegConverter
{
    public function __construct(
        private readonly PdfConverter $converter,
        private readonly string $birdPath,
        private readonly FileNameGenerator $fileNameGenerator
    ) {}

    public function convert(ImportedBird $bird): void
    {
        $img = $this->fileNameGenerator->generate(
            $bird->getName(),
            'jpg'
        );
        $this->converter->convert(
            $bird->getSavedPdfPath(),
            sprintf(
                '%s%s',
                $this->birdPath,
                $img
            )
        );
        $bird->setSavedImgPath($img);
    }
}
