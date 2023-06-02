<?php

declare(strict_types=1);

spl_autoload_register(function ($className) {
    $className = strpos($className, 'App\\') === 0
        ? mb_substr($className, 4, mb_strlen($className))
        : $className;

    $className = str_replace('\\', '/', $className);

    include sprintf('src/%s.php', $className);
});

