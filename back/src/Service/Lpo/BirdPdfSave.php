<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\ValueObject\Lpo\ImportedBird;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BirdPdfSave
{
    public function __construct(
        private readonly HttpClientInterface $lpoClient,
        private readonly string $birdPath
    ) {
    }

    public function save(ImportedBird $bird): void
    {
        $url = $this->getPdfUrl($bird);

        if ($url !== null) {
            $bird->setPdfUrl($url);
            $this->writePdfFile($bird);
        }
    }

    private function getPdfUrl(ImportedBird $bird): ?string
    {
        $pdfUrlRes = [];
        preg_match(
            '#href="(?P<url>[0-9a-zA-Z.:/.-]*.pdf)">#',
            $this->lpoClient->request('GET', sprintf('?m_id=15&frmSpecies=%d', $bird->getLpoId()))->getContent(),
            $pdfUrlRes
        );

        if (!isset($pdfUrlRes['url'])) {
            return null;
        }

        return $pdfUrlRes['url'];
    }

    private function writePdfFile(ImportedBird $bird): void
    {
        $fileName = sprintf(
            '%s.pdf',
            preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($bird->getName())))
        );
        $fs = new Filesystem();
        $path = sprintf('%s%s', $this->birdPath, $fileName);
        $fs->dumpFile(
            $path,
            file_get_contents($bird->getPdfUrl())
        );
        $bird->setSavedPath($path);
    }
}
