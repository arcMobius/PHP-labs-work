<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{
    protected ?int $authorId = null;
    protected ?string $name = null;
    protected ?string $text = null;
    protected ?string $createdAt = null;

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAuthor(): ?User
    {
        return User::getById($this->authorId);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}