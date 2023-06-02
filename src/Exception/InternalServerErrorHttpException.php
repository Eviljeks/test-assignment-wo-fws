<?php

declare(strict_types=1);

namespace App\Exception;

final class InternalServerErrorHttpException extends HttpException
{
    public function __construct(string $message = 'Server error!')
    {
        parent::__construct($message, 500);
    }
}