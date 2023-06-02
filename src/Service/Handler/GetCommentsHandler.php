<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\Model\Comment;
use App\Service\CommentRepository;

final class GetCommentsHandler
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return Comment[]
     */
    public function handle(): array
    {
        return $this->commentRepository->findAll();
    }
}