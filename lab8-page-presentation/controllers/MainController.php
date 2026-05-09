<?php

class MainController
{
    public function main(): array
    {
        return [
            'content' => '
                <h2>Статья 1</h2>
                <p>Всем привет, это текст первой статьи</p>
                <hr>

                <h2>Статья 2</h2>
                <p>Всем привет, это текст второй статьи</p>
            ',
        ];
    }

    public function aboutMe(): array
    {
        return [
            'content' => '
                <h2>Обо мне</h2>
                <p>Это страница с информацией об авторе блога.</p>
            ',
        ];
    }

    public function sayHello(string $name): array
    {
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return [
            'title' => 'Страница приветствия',
            'content' => '
                <h2>Приветствие</h2>
                <p>Привет, ' . $name . '</p>
            ',
        ];
    }

    public function sayBye(string $name): array
    {
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return [
            'content' => '
                <h2>Прощание</h2>
                <p>Пока, ' . $name . '</p>
            ',
        ];
    }
}