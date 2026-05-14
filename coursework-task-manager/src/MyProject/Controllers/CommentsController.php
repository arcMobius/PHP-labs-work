<?php

namespace MyProject\Controllers;

use MyProject\Models\Comments\Comment;
use MyProject\Models\Tasks\Task;
use MyProject\Models\Users\User;
use MyProject\View\View;

class CommentsController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function add(int $taskId): void
    {
        $task = Task::getById($taskId);

        if ($task === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /tasks/' . $taskId);
            exit;
        }

        $authorId = (int) ($_POST['author_id'] ?? 0);
        $text = trim($_POST['text'] ?? '');

        if ($text === '' || User::getById($authorId) === null) {
            header('Location: /tasks/' . $taskId);
            exit;
        }

        $commentId = Comment::create($authorId, $taskId, $text);

        header('Location: /tasks/' . $taskId . '#comment' . $commentId);
        exit;
    }

    public function edit(int $commentId): void
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authorId = (int) ($_POST['author_id'] ?? 0);
            $text = trim($_POST['text'] ?? '');

            if ($text !== '' && User::getById($authorId) !== null) {
                $comment->setAuthorId($authorId);
                $comment->setText($text);
                $comment->setUpdatedAt(date('Y-m-d H:i:s'));
                $comment->save();

                header('Location: /tasks/' . $comment->getTaskId() . '#comment' . $comment->getId());
                exit;
            }

            $message = 'Ошибка: выберите автора и заполните текст комментария';
        }

        $this->view->renderHtml('comments/edit.php', [
            'comment' => $comment,
            'users' => User::findAll(),
            'message' => $message,
        ]);
    }
}