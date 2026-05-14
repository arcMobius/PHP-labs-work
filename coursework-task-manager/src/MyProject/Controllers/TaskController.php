<?php

namespace MyProject\Controllers;

use MyProject\Models\Tasks\Task;
use MyProject\View\View;
use MyProject\Models\Users\User;

class TaskController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

public function create(): void
{
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authorId = (int) ($_POST['author_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'new';
        $priority = $_POST['priority'] ?? 'medium';
        $deadline = trim($_POST['deadline'] ?? '');

        $allowedStatuses = ['new', 'in_progress', 'done'];
        $allowedPriorities = ['low', 'medium', 'high'];

        if (
            $title !== ''
            && $description !== ''
            && User::getById($authorId) !== null
            && in_array($status, $allowedStatuses, true)
            && in_array($priority, $allowedPriorities, true)
        ) {
            $taskId = Task::create(
                $authorId,
                $title,
                $description,
                $status,
                $priority,
                $deadline !== '' ? $deadline : null
            );

            header('Location: /tasks/' . $taskId);
            exit;
        }

        $message = 'Ошибка: заполните название, описание и выберите корректные данные';
    }

    $this->view->renderHtml('tasks/create.php', [
        'users' => User::findAll(),
        'message' => $message,
    ]);
}

        public function edit(int $taskId): void
    {
        $task = Task::getById($taskId);

        if ($task === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'new';
            $priority = $_POST['priority'] ?? 'medium';
            $deadline = trim($_POST['deadline'] ?? '');

            if ($title !== '' && $description !== '') {
                $task->setTitle($title);
                $task->setDescription($description);
                $task->setStatus($status);
                $task->setPriority($priority);
                $task->setDeadline($deadline !== '' ? $deadline : null);
                $task->setUpdatedAt(date('Y-m-d H:i:s'));
                $task->save();

                header('Location: /tasks/' . $task->getId());
                exit;
            }

            $message = 'Ошибка: заполните название и описание задачи';
        }

        $this->view->renderHtml('tasks/edit.php', [
            'task' => $task,
            'message' => $message,
        ]);
    }
}