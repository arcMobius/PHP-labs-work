<?php

namespace MyProject\Controllers;

use MyProject\Models\Tasks\Task;
use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main(): void
    {
        $tasks = Task::findAll();

        $this->view->renderHtml('main/main.php', [
            'tasks' => $tasks,
        ]);
    }
}