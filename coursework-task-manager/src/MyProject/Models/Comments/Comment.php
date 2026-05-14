<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $authorId;
    protected $taskId;
    protected $text;
    protected $createdAt;
    protected $updatedAt;

    public function getAuthorId(): int
    {
        return (int) $this->authorId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getAuthor(): ?User
    {
        return User::getById($this->authorId);
    }

    public function getTaskId(): int
    {
        return (int) $this->taskId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public static function findByTaskId(int $taskId): array
    {
        $db = Db::getInstance();

        return $db->query(
            'SELECT * FROM `comments` WHERE `task_id` = :taskId ORDER BY `created_at` ASC;',
            [':taskId' => $taskId],
            static::class
        );
    }

    public static function create(int $authorId, int $taskId, string $text): int
    {
        $db = Db::getInstance();

        $db->execute(
            'INSERT INTO `comments` (`author_id`, `task_id`, `text`) VALUES (:authorId, :taskId, :text);',
            [
                ':authorId' => $authorId,
                ':taskId' => $taskId,
                ':text' => $text,
            ]
        );

        return (int) $db->getLastInsertId();
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}