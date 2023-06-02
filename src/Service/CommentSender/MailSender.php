<?php

declare(strict_types=1);

namespace App\Service\CommentSender;

use App\Model\Comment;

final class MailSender implements CommentSenderInterface
{
    public function send(Comment $comment): void
    {
        // do some work here
    }
}