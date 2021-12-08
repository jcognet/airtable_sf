<?php
declare(strict_types=1);

namespace App\Service\Builder;

use App\ValueObject\Article;
use Carbon\Carbon;

class ArticleBuilder implements BuilderInterface
{
    public function build(array $data): Article
    {
        $records = $data['records'];
        $key = array_rand($records);

        return new Article(
            $records[$key]['fields']['Name'] ?? '',
            $records[$key]['fields']['body'] ?? $records[$key]['fields']['Citation'] ?? '',
            Carbon::parse($records[$key]['createdTime']),
        );
    }
}
