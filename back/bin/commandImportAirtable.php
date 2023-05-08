<?php
declare(strict_types=1);

include 'defaultCommand.php';
execSymfonyCommand('app:airtable:import -vv');
