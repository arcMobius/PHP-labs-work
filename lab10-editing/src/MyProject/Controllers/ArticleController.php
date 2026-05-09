<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;

class ArticleController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $text = trim($_POST['text'] ?? '');

            if ($name !== '' && $text !== '') {
                $article->setName($name);
                $article->setText($text);
                $article->save();

                $message = 'Статья обновлена';
            } else {
                $message = 'Ошибка: заполните название и текст статьи';
            }
        }

        $this->view->renderHtml('articles/edit.php', [
            'article' => $article,
            'message' => $message,
        ]);
    }
}