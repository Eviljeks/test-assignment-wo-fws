<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Comment;
use PDO;

final class CommentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @return Comment[]
     */
    public function findAll(): array
    {
        $sql = 'SELECT id, text FROM comments ORDER BY id desc';

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    /**
     * @throws \Throwable
     */
    public function save(string $text): Comment
    {
        $sql = 'INSERT INTO comments (text) VALUES (:text)';

        try {
            $this->pdo->beginTransaction();

            $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

            $sth->execute(['text' => $text]);

            $id = (int) $this->pdo->lastInsertId();

            $comment = $this->get($id);

            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();

            throw $e;
        }

        return $comment;
    }

    public function get(int $id): Comment
    {
        $sql = 'SELECT id, text FROM comments WHERE id = :id';

        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute(['id' => $id]);

        return  $sth->fetchObject(Comment::class);
    }
}