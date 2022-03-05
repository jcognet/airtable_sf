<?php
declare(strict_types=1);

namespace App\Service\Git;

use App\ValueObject\Git\Command;
use Carbon\Carbon;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Twig\Environment;

class Deploy implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const SUBJECT = 'Fun Effect %s déploiement du %s';
    private const SUBJECT_FAILURE = 'Caca déploiement du %s';

    private MailerInterface $mailer;
    private string $mailerFrom;
    private string $mailerTo;
    private string $projectDir;
    private string $githubSecret;
    private TagWriter $tagWriter;
    private string $environment;
    private Environment $twig;

    public function __construct(
        MailerInterface $mailer,
        string $mailerFrom,
        string $mailerTo,
        string $projectDir,
        string $githubSecret,
        TagWriter $tagWriter,
        string $environment,
        Environment $twig
    ) {
        $this->mailer = $mailer;
        $this->mailerFrom = $mailerFrom;
        $this->mailerTo = $mailerTo;
        $this->projectDir = $projectDir;
        $this->githubSecret = $githubSecret;
        $this->tagWriter = $tagWriter;
        $this->environment = $environment;
        $this->twig = $twig;
    }

    public function checkAccess(Request $request): bool
    {
        $this->twig->setCache(false);

        [$hash, $headerSecret] = explode('=', $request->headers->get('X-Hub-Signature-256'));
        $this->logger->info('header', [$hash, $headerSecret]);
        $requestSecret = hash_hmac($hash, $request->getContent(), $this->githubSecret);
        $this->logger->info('content', [$requestSecret]);

        return hash_equals($requestSecret, $headerSecret);
    }

    public function deploy(array $git): void
    {
        $returns = [];

        $body = $this->twig->render('email/git.html.twig', [
            'date' => Carbon::now(),
            'git' => $git,
        ]);

        try {
            foreach ($this->getCalls() as $call) {
                $process = new Process($call);
                $process->setWorkingDirectory($this->projectDir);

                if (is_string($call)) {
                    $this->logger->info(sprintf('Current command: %s ', $call));
                } elseif (is_array($call)) {
                    $this->logger->info(sprintf('Current command: %s ', implode(' ', $call)));
                }

                $process->mustRun(null, ['COMPOSER_HOME' => $this->projectDir . '/../composer_cache']);

                $this->logger->info($process->getOutput());
                $returns[] = new Command(
                    $call,
                    $process->getOutput()
                );
            }

            $this->tagWriter->write($git['ref']);

            $this->sendEmail(
                $body,
                sprintf(self::SUBJECT, $git['ref'], Carbon::now()->format('d/m/Y')),
                $returns
            );
        } catch (\Exception $e) {
            $this->sendEmail(
                $body,
                sprintf(self::SUBJECT_FAILURE, Carbon::now()->format('d/m/Y')),
                $returns,
                $e
            );

            throw $e;
        }
    }

    private function getCalls(): array
    {
        $phpBinaryFinder = new PhpExecutableFinder();
        $phpBinaryPath = $phpBinaryFinder->find();

        switch ($this->environment) {
            case 'prod':
                return [
                    ['git', 'pull'],
                    [$phpBinaryPath, sprintf('%s/composer.phar', $this->projectDir), 'install'],
                    [$phpBinaryPath, sprintf('%s/composer.phar', $this->projectDir), 'dump-autoload', '--no-dev', '--classmap-authoritative'],
                    [$phpBinaryPath, 'bin/console', 'cache:clear'],
                ];
            default:
                return [
                    ['composer', 'install'],
                    [$phpBinaryPath, 'bin/console', 'cache:clear'],
                ];
        }
    }

    /**
     * @param Command[] $returns
     */
    private function sendEmail(
        string $body,
        string $subject,
        array $returns,
        ?\Exception $exception = null
    ): void
    {
        $returnsString = '';
        $exceptionString = '';

        foreach ($returns as $return) {
            $returnsString .= sprintf('%s: %s%s', implode(' ', $return->getProcess()), $return->getReturn(), PHP_EOL);
        }

        if ($exception) {
            $exceptionString = sprintf(
                '<h2>Erreur</h2>
                        <div style="background-color: red;color: white">
                            %s
                        </div>
            ',
                $exception->getMessage()
            );
        }

        $body = str_replace(
            ['##returns##', '##exception##'],
            [$returnsString, $exceptionString],
            $body
        );

        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject($subject)
            ->html($body)
        ;

        $this->mailer->send($email);
    }
}
