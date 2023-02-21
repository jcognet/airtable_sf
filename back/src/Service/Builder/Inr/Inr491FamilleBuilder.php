<?php
declare(strict_types=1);

namespace App\Service\Builder\Inr;

use App\ValueObject\Inr\Famille;

class Inr491FamilleBuilder
{
    public function build(
        string $dataTitle,
        string $dataBody,
        string $url
    ): ?Famille {
        $dataTitle = str_replace(
            ['Famille ', '"'],
            '',
            trim(strip_tags($dataTitle))
        );
        $posPipe = mb_strpos($dataTitle, '|');
        $title = trim(mb_substr($dataTitle, 0, $posPipe - 1));

        [$recommandations, $criteres] = explode(
            '-',
            trim(mb_substr($dataTitle, $posPipe + 1))
        );

        return new Famille(
            trim($title),
            strip_tags(trim($dataBody)),
            strip_tags(trim($recommandations)),
            trim($criteres),
            $url
        );
    }
}
