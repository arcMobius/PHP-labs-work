<?php

namespace MyProject\Controllers;

use MyProject\Models\Comments\Comment;
use MyProject\Models\Tasks\Task;
use MyProject\Models\Users\User;
use MyProject\View\View;

class TasksController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function show(int $taskId): void
    {
        $task = Task::getById($taskId);

        if ($task === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $comments = Comment::findByTaskId($taskId);
        $users = User::findAll();

        $this->view->renderHtml('tasks/show.php', [
            'task' => $task,
            'author' => $task->getAuthor(),
            'comments' => $comments,
            'users' => $users,
        ]);
    }
}