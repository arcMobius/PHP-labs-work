<?php

return [
    '~^/$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^/articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'show'],
    '~^/article/(\d+)/edit$~' => [\MyProject\Controllers\ArticleController::class, 'edit'],
];