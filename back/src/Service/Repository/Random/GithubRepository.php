<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubRepository implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private HttpClientInterface $githubrepositoryClient;

    public function __construct(HttpClientInterface $githubrepositoryClient)
    {
        $this->githubrepositoryClient = $githubrepositoryClient;
    }

    public function getNbIssues(): int
    {
        try {
            $content = json_decode($this->githubrepositoryClient->request('GET', 'issues')->getContent(), true);

            return count($content);
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error when querying github: %s', $e->getMessage()), [
                'exception' => [
                    'file' => $e->getFile(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);

            return 0;
        }
    }
}
