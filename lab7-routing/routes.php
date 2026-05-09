<?php

return [
    '~^/$~' => [
        'controller' => MainController::class,
        'action' => 'main',
    ],

    '~^/about-me$~' => [
        'controller' => MainController::class,
        'action' => 'aboutMe',
    ],

    '~^/hello/([A-Za-zА-Яа-яЁё0-9_-]+)$~u' => [
        'controller' => MainController::class,
        'action' => 'sayHello',
    ],

    '~^/bye/([A-Za-zА-Яа-яЁё0-9_-]+)$~u' => [
        'controller' => MainController::class,
        'action' => 'sayBye',
    ],
];