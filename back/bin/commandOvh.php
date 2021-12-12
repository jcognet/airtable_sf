<?php
declare(strict_types=1);
$phpPath = 'php';
$cmd = sprintf('%s %s/console a:n:h -vvv', $phpPath, __DIR__);
$now = new \DateTime();
echo $cmd . "\n";
$output = [];
echo $now->format('d/m/Y - H:i:s') . "\n";
exec($cmd, $output);
echo implode("\n", $output);
