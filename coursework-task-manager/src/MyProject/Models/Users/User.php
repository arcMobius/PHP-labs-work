<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected ?string $nickname = null;
    protected ?string $email = null;
    protected ?int $isConfirmed = null;
    protected ?string $role = null;
    protected ?string $passwordHash = null;
    protected ?string $authToken = null;
    protected ?string $createdAt = null;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}