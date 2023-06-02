<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BadRequestHttpException;
use App\Service\CommentRepository;
use App\Service\CommentSender\CommentSenderInterface;
use App\Service\Handler\SaveCommentHandler;
use App\Service\Renderer;
use App\Service\Session;

final class SaveCommentController
{
    private Renderer $renderer;
    private SaveCommentHandler $saveCommentHandler;
    private Session $session;

    public function __construct(Renderer $renderer, SaveCommentHandler $saveCommentHandler, Session $session)
    {
        $this->renderer = $renderer;
        $this->saveCommentHandler = $saveCommentHandler;
        $this->session = $session;
    }

    /**
     * @throws BadRequestHttpException
     * @throws \Throwable
     */
    public function __invoke(): void
    {
        $text = $_POST['text'] ?? null;
        $csrfToken = $_POST['csrf_token'] ?? null;

        if (!is_string($text) || !is_string($csrfToken)) {
            throw new BadRequestHttpException();
        }

        if (!$this->validateCSTFToken($csrfToken)) {
            throw new BadRequestHttpException('Csrf token is not valid');
        }

        $text = htmlspecialchars($text);

        $comment = $this->saveCommentHandler->handle($text);

        $this->renderer->render('my_comment', ['comment' => $comment]);
    }

    private function validateCSTFToken(string $token): bool
    {
        return$this->session->getCSRFToken() === $token;
    }
}