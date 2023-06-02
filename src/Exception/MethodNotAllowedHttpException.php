<?php

declare(strict_types=1);

namespace App\Exception;

final class MethodNotAllowedHttpException extends HttpException
{
    public function __construct(string $message = 'Method not allowed!')
    {
        parent::__construct($message, 405);
    }
}