<?php
declare(strict_types=1);

include 'defaultCommand.php';
execSymfonyCommand('app:lpo:pdf:fetch -vv');
