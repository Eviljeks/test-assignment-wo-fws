<?php

declare(strict_types=1);

namespace App\Service;

final class Renderer
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $view, array $data): void
    {
        include sprintf('%s/%s.php', $this->path, $view);
    }
}