<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubRepository implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(private readonly HttpClientInterface $githubrepositoryClient)
    {
    }

    public function getNbIssues(): int
    {
        try {
            $content = json_decode($this->githubrepositoryClient->request('GET', 'issues')->getContent(), true, 512, JSON_THROW_ON_ERROR);

            return is_countable($content) ? count($content) : 0;
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
