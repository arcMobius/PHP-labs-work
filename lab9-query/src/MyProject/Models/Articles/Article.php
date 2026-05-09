<?php

namespace MyProject\Models\Articles;

class Article
{
    private ?int $id = null;
    private ?int $authorId = null;
    private string $name;
    private string $text;
    private string $createdAt;

    public function __set(string $name, $value): void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}