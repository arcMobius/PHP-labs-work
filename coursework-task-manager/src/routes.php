<?php

return [
    '~^/$~' => [\MyProject\Controllers\MainController::class, 'main'],

    '~^/tasks/create$~' => [\MyProject\Controllers\TaskController::class, 'create'],
    '~^/tasks/(\d+)$~' => [\MyProject\Controllers\TasksController::class, 'show'],
    '~^/tasks/(\d+)/edit$~' => [\MyProject\Controllers\TaskController::class, 'edit'],

    '~^/tasks/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^/comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
];