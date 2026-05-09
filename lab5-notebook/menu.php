<?php
if (!defined('APP_STARTED')) {
    exit('Доступ запрещён.');
}

function getMenu(): string
{
    $allowedPages = ['view', 'add', 'edit', 'delete'];
    $page = $_GET['page'] ?? 'view';

    if (!in_array($page, $allowedPages)) {
        $page = 'view';
    }

    $allowedSorts = ['created', 'last_name', 'birth_date'];
    $sort = $_GET['sort'] ?? 'created';

    if (!in_array($sort, $allowedSorts)) {
        $sort = 'created';
    }

    $mainItems = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];

    $html = '<nav class="menu">';

    foreach ($mainItems as $key => $title) {
        $activeClass = $page === $key ? 'active' : '';
        $html .= '<a class="' . $activeClass . '" href="index.php?page=' . $key . '">' . $title . '</a>';
    }

    $html .= '</nav>';

    if ($page === 'view') {
        $sortItems = [
            'created' => 'По добавлению',
            'last_name' => 'По фамилии',
            'birth_date' => 'По дате рождения',
        ];

        $html .= '<nav class="submenu">';

        foreach ($sortItems as $key => $title) {
            $activeClass = $sort === $key ? 'active' : '';
            $html .= '<a class="' . $activeClass . '" href="index.php?page=view&sort=' . $key . '">' . $title . '</a>';
        }

        $html .= '</nav>';
    }

    return $html;
}