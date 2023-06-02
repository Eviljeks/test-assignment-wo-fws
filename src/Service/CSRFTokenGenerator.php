<?php

declare(strict_types=1);

namespace App\Service;

final class CSRFTokenGenerator
{
    private string $salt;

    public function __construct(string $salt)
    {
        $this->salt = $salt;
    }

    public function generate(): string
    {
        return sha1($this->salt . uniqid($this->salt));
    }
}