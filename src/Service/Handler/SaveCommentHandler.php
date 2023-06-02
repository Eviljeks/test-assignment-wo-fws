<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\Model\Comment;
use App\Service\CommentRepository;
use App\Service\CommentSender\CommentSenderInterface;
use App\Service\Renderer;

final class SaveCommentHandler
{
    private CommentRepository $commentRepository;
    /** @var CommentSenderInterface[]  */
    private array $senders;

    public function __construct(CommentRepository $commentRepository, CommentSenderInterface ...$senders)
    {
        $this->commentRepository = $commentRepository;
        $this->senders = $senders;
    }

    public function handle(string $text): Comment
    {
        $comment = $this->commentRepository->save($text);

        foreach ($this->senders as $sender) {
            $sender->send($comment);
        }

        return $comment;
    }
}