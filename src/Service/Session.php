<?php

declare(strict_types=1);

namespace App\Service;

final class Session
{
    private string $tokenFieldName;

    public function __construct(string $tokenFieldName)
    {
        $this->tokenFieldName = $tokenFieldName;
    }

    public function getCSRFToken(): ?string
    {
        return $_SESSION[$this->tokenFieldName] ?? null;
    }

    public function setCSRFToken(string $token): void
    {
        $_SESSION[$this->tokenFieldName] = $token;
    }
}