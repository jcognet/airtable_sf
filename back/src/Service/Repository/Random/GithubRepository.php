<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CatBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubRepository
{
    private HttpClientInterface $githubrepositoryClient;

    public function __construct(HttpClientInterface $githubrepositoryClient)
    {
        $this->githubrepositoryClient = $githubrepositoryClient;
    }

    public function getNbIssues(): int
    {
        $content = json_decode($this->githubrepositoryClient->request('GET', 'issues')->getContent(), true);

        return count($content);
    }
}
