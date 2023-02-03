<?php
declare(strict_types=1);

namespace App\Service\Lpo;

use App\Service\FileNameGenerator;
use App\ValueObject\Lpo\ImportedBird;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BirdPdfSave
{
    public function __construct(
        private readonly HttpClientInterface $lpoClient,
        private readonly string $birdPath,
        private readonly FileNameGenerator $fileNameGenerator
    ) {
    }

    public function save(ImportedBird $bird): void
    {
        $url = $this->getDataFromLpoSite($bird);

        if ($url !== null) {
            $bird->setPdfUrl($url);
            $this->writePdfFile($bird);
        }
    }

    private function getDataFromLpoSite(ImportedBird $bird): ?string
    {
        $request = $this->lpoClient->request('GET', sprintf('?m_id=15&frmSpecies=%d', $bird->getLpoId()));
        $content = $request->getContent();
        $urlPo = $request->getInfo()['url'];
        $bird->setLpoUrl($urlPo);
        $fullNameRes = [];
        preg_match(
            '#<div style="text-align: left; font-size: 16px; font-weight: bold;">(?P<name>[Ééèêâçàa/-zA-Z\s()\-\'\.]*)</div>#',
            $content,
            $fullNameRes
        );
        $bird->setFullName(trim($fullNameRes['name']));
        $pdfUrlRes = [];
        preg_match(
            '#href="(?P<url>[0-9a-zA-Z.:/.-]*.pdf)">#',
            $content,
            $pdfUrlRes
        );

        if (!isset($pdfUrlRes['url'])) {
            return null;
        }

        return $pdfUrlRes['url'];
    }

    private function writePdfFile(ImportedBird $bird): void
    {
        $fs = new Filesystem();
        $path = sprintf(
            '%s%s',
            $this->birdPath,
            $this->fileNameGenerator->generate(
                $bird->getName(),
                'pdf'
            )
        );
        $fs->dumpFile(
            $path,
            file_get_contents($bird->getPdfUrl())
        );
        $bird->setSavedPdfPath($path);
    }
}
