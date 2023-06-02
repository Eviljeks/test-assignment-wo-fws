<?php

declare(strict_types=1);

namespace App\Service\CommentSender;

use App\Model\Comment;

interface CommentSenderInterface
{
    public function send(Comment $comment): void;
}