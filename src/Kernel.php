<?php

declare(strict_types=1);

namespace App;

use App\Controller\GetCommentsController;
use App\Controller\SaveCommentController;
use App\Exception\HttpException;
use App\Exception\InternalServerErrorHttpException;
use App\Service\CommentRepository;
use App\Service\CommentSender\MailSender;
use App\Service\CommentSender\SMSSender;
use App\Service\CSRFTokenGenerator;
use App\Service\Handler\GetCommentsHandler;
use App\Service\Handler\SaveCommentHandler;
use App\Service\Renderer;
use App\Service\Session;
use PDO;

final class Kernel
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function boot(): void
    {
        $pdo = new PDO($this->config['DB_DSN'], $this->config['DB_USER'], $this->config['DB_PASSWORD'], [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        session_start();

        $renderer = new Renderer(__DIR__ . '/../views');
        $commentRepo = new CommentRepository($pdo);
        $session = new Session($this->config['CSRF_TOKEN_SESSION_KEY']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $controller = new GetCommentsController(
                $renderer,
                new GetCommentsHandler($commentRepo),
                $session,
                new CSRFTokenGenerator($this->config['CSRF_TOKEN_SALT']),
            );
        } else {
            $controller = new SaveCommentController(
                $renderer,
                new SaveCommentHandler($commentRepo, new SMSSender(), new MailSender()),
                $session,
            );
        }

        try {
            $controller();
        } catch (HttpException $e) {
            $renderer->render('error', ['exception' => $e]);
        } catch (\Throwable $e) {
            $renderer->render('error', ['exception' => new InternalServerErrorHttpException()]);
        }
    }
}