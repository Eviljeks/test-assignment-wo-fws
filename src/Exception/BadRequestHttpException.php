<?php

declare(strict_types=1);

namespace App\Exception;

final class BadRequestHttpException extends HttpException
{
    public function __construct(string $message = 'Bad request!')
    {
        parent::__construct($message, 400);
    }
}