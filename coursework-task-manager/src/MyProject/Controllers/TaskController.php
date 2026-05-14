<?php

namespace MyProject\Controllers;

use MyProject\Models\Tasks\Task;
use MyProject\View\View;

class TaskController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
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