<?php
declare(strict_types=1);

namespace App\Service\Git;

use App\ValueObject\Git\Command;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class Deploy
{
    private const SUBJECT = 'Fun Effect %s déploiement du %s';
    private const SUBJECT_FAILURE = 'Caca déploiement du %s';

    private LoggerInterface $logger;
    private MailerInterface $mailer;
    private string $mailerFrom;
    private string $mailerTo;
    private string $projectDir;
    private string $githubSecret;

    public function __construct(
        LoggerInterface $logger,
        MailerInterface $mailer,
        string $mailerFrom,
        string $mailerTo,
        string $projectDir,
        string $githubSecret
    ) {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->mailerFrom = $mailerFrom;
        $this->mailerTo = $mailerTo;
        $this->projectDir = $projectDir;
        $this->githubSecret = $githubSecret;
    }

    public function checkAccess(Request $request): bool
    {
        [$hash, $headerSecret] = explode('=', $request->headers->get('X-Hub-Signature-256'));
        $this->logger->info('header', [$hash, $headerSecret]);
        $requestSecret = hash_hmac($hash, $request->getContent(), $this->githubSecret);
        $this->logger->info('content', [$requestSecret]);

        return hash_equals($requestSecret, $headerSecret);
    }

    public function deploy(array $git): void
    {
        $phpBinaryFinder = new PhpExecutableFinder();
        $phpBinaryPath = $phpBinaryFinder->find();

        $listCalls = [
            ['git', 'pull'],
            [$phpBinaryPath, sprintf('%s/composer.phar', $this->projectDir), 'install'],
            [$phpBinaryPath, 'bin/console', 'cache:clear'],
        ];

        $returns = [];

        try {
            foreach ($listCalls as $call) {
                $process = new Process($call);
                $process->setWorkingDirectory($this->projectDir);
                $process->mustRun(null, ['COMPOSER_HOME' => $this->projectDir . '/../composer_cache']);

                $this->logger->info($process->getOutput());
                $returns[] = new Command(
                    $call,
                    $process->getOutput()
                );
            }

            $email = (new TemplatedEmail())
                ->to($this->mailerTo)
                ->from($this->mailerFrom)
                ->subject(sprintf(self::SUBJECT, $git['ref'], Carbon::now()->format('d/m/Y')))
                ->htmlTemplate('email/git.html.twig')
                ->context([
                    'returns' => $returns,
                    'date' => Carbon::now(),
                    'git' => $git,
                ])
            ;

            $this->mailer->send($email);
        } catch (\Exception $e) {
            $email = (new TemplatedEmail())
                ->to($this->mailerTo)
                ->from($this->mailerFrom)
                ->subject(sprintf(self::SUBJECT_FAILURE, Carbon::now()->format('d/m/Y')))
                ->htmlTemplate('email/git.html.twig')
                ->context([
                    'returns' => $returns,
                    'date' => Carbon::now(),
                    'exception' => $e,
                    'git' => $git,
                ])
            ;
            $this->mailer->send($email);

            throw $e;
        }
    }
}