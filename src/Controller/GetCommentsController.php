<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CSRFTokenGenerator;
use App\Service\Handler\GetCommentsHandler;
use App\Service\Renderer;
use App\Service\Session;

final class GetCommentsController
{
    private Renderer $renderer;
    private GetCommentsHandler $getCommentsHandler;
    private CSRFTokenGenerator $csrfTokenGenerator;
    private Session $session;

    public function __construct(
        Renderer $renderer,
        GetCommentsHandler $getCommentsHandler,
        Session $session,
        CSRFTokenGenerator $csrfTokenGenerator
    ) {
        $this->renderer = $renderer;
        $this->getCommentsHandler = $getCommentsHandler;
        $this->session = $session;
        $this->csrfTokenGenerator = $csrfTokenGenerator;
    }

    public function __invoke(): void
    {
        $comments = $this->getCommentsHandler->handle();

        $token = $this->session->getCSRFToken();

        if ($token === null) {
            $this->session->setCSRFToken($this->csrfTokenGenerator->generate());
        }

        $this->renderer->render('all_comments', ['comments' => $comments, 'csrf_token' => $this->session->getCSRFToken()]);
    }

}