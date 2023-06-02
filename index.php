<?php

declare(strict_types=1);

require 'autoload.php';

$config = include_once 'config.php';

$kernel = new App\Kernel($config);

$kernel->boot();