<?php
declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SizeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_file_size', $this->formatFileSize(...)),
        ];
    }

    public function formatFileSize($bytes, $precision = 2): string
    {
        // https://stackoverflow.com/questions/15280310/readable-file-sizes-with-the-twig-templating-system
        $units = ['O', 'Ko', 'Mo', 'Go', 'To'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= 1024 ** $pow;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
