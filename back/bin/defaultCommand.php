<?php
declare(strict_types=1);

function execSymfonyCommand($command): void
{
    $phpPath = '/usr/local/php7.4/bin/php';
    $cmd = sprintf('%s %s/console %s', $phpPath, __DIR__, $command);
    $now = new \DateTime();
    echo $cmd . "\n";
    $output = [];
    echo $now->format('d/m/Y - H:i:s') . "\n";
    exec($cmd, $output);
    echo implode("\n", $output);
}
