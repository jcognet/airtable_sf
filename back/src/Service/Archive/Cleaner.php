<?php
declare(strict_types=1);

namespace App\Service\Archive;

use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Cleaner
{
    public function __construct(private readonly string $deployArchiveJsonPath)
    {
    }

    public function clean(Carbon $from): int
    {
        $finder = new Finder();
        $filesystem = new Filesystem();

        $finder->files()
            ->in($this->deployArchiveJsonPath)
            ->name('*.json')
            ->date(sprintf('<=%s', $from->format('Y-m-d')))
        ;
        $nb = $finder->count();
        $filesystem->remove($finder->files()->in($this->deployArchiveJsonPath));

        return $nb;
    }
}
