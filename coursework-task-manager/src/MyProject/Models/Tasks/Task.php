<?php

namespace MyProject\Models\Tasks;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Task extends ActiveRecordEntity
{
    protected $authorId;
    protected $title;
    protected $description;
    protected $status;
    protected $priority;
    protected $deadline;
    protected $createdAt;
    protected $updatedAt;

    public function getAuthorId(): int
    {
        return (int) $this->authorId;
    }

    public function getAuthor(): ?User
    {
        return User::getById($this->authorId);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function setDeadline(?string $deadline): void
    {
        $this->deadline = $deadline;
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

    public function getStatusLabel(): string
    {
        switch ($this->status) {
            case 'new':
                return 'Новая';
            case 'in_progress':
                return 'В работе';
            case 'done':
                return 'Выполнена';
            default:
                return $this->status;
        }
    }

    public function getPriorityLabel(): string
    {
        switch ($this->priority) {
            case 'low':
                return 'Низкий';
            case 'medium':
                return 'Средний';
            case 'high':
                return 'Высокий';
            default:
                return $this->priority;
        }
    }

public static function create(
    int $authorId,
    string $title,
    string $description,
    string $status,
    string $priority,
    ?string $deadline
): int {
    $db = Db::getInstance();

    $db->execute(
        'INSERT INTO `tasks` (`author_id`, `title`, `description`, `status`, `priority`, `deadline`)
         VALUES (:authorId, :title, :description, :status, :priority, :deadline);',
        [
            ':authorId' => $authorId,
            ':title' => $title,
            ':description' => $description,
            ':status' => $status,
            ':priority' => $priority,
            ':deadline' => $deadline,
        ]
    );

    return (int) $db->getLastInsertId();
}

    protected static function getTableName(): string
    {
        return 'tasks';
    }
}