<?php

namespace MyProject\Models\Users;

class User
{
    private ?int $id = null;
    private string $nickname;
    private string $email;
    private int $isConfirmed;
    private string $role;
    private string $passwordHash;
    private string $authToken;
    private string $createdAt;

    public function __set(string $name, $value): void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}