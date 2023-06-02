<?php

declare(strict_types=1);

namespace App;

use App\Controller\GetCommentsController;
use App\Controller\SaveCommentController;
use App\Exception\HttpException;
use App\Exception\InternalServerErrorHttpException;
use App\Exception\MethodNotAllowedHttpException;
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

        $renderer = new Renderer(__DIR__ . '/../views');
        $commentRepo = new CommentRepository($pdo);
        $session = new Session($this->config['CSRF_TOKEN_SESSION_KEY']);

        $session->start();

        try {
            $controller = $this->resolveController($renderer, $commentRepo, $session);
            $controller()();
        } catch (HttpException $e) {
            $this->handleException($renderer, $e);
        } catch (\Throwable $e) {
            $exception = new InternalServerErrorHttpException();
            $this->handleException($renderer, $exception);
        }
    }

    /**
     * @param Renderer $renderer
     * @param CommentRepository $commentRepo
     * @param Session $session
     */
    private function resolveController
    (
        Renderer $renderer,
        CommentRepository $commentRepo,
        Session $session
    ): callable {
        $routes = [
            '/all_comments.php' => [
                'GET' => fn (): callable => new GetCommentsController(
                    $renderer,
                    new GetCommentsHandler($commentRepo),
                    $session,
                    new CSRFTokenGenerator($this->config['CSRF_TOKEN_SALT']),
                ),
            ],
            '/' => [
                'GET' => fn (): callable => new GetCommentsController(
                    $renderer,
                    new GetCommentsHandler($commentRepo),
                    $session,
                    new CSRFTokenGenerator($this->config['CSRF_TOKEN_SALT']),
                ),
            ],
            '/my_comment.php' => [
                'POST' => fn (): callable => new SaveCommentController(
                    $renderer,
                    new SaveCommentHandler($commentRepo, new SMSSender(), new MailSender()),
                    $session,
                ),
            ],
        ];

        $reqUri = $_SERVER['REQUEST_URI'];
        $reqMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($routes as $uri => $methods) {
            if ($uri !== $reqUri) {
                continue;
            }

            foreach ($methods as $method => $callable) {
                if ($method !== $reqMethod) {
                    continue;
                }

                return $callable;
            }
        }

        throw new MethodNotAllowedHttpException();
    }

    private function handleException(Renderer $renderer, HttpException $e): void
    {
        http_response_code($e->getCode());
        $renderer->render('error', ['exception' => $e]);
    }
}