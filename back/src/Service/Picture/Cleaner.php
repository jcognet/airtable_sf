<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Service\Contract\CleanerInterface;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Cleaner implements CleanerInterface
{
    public function __construct(
        private readonly string $cachedImagePath
    ) {}

    public function clean(Carbon $from): int
    {
        $finder = new Finder();
        $filesystem = new Filesystem();

        $files = $finder->files()
            ->in($this->cachedImagePath)
            ->name('*.jpg')
            ->date(sprintf('<=%s', $from->format('Y-m-d')))
        ;

        $nb = $files->count();
        $filesystem->remove($files);

        return $nb;
    }
}
