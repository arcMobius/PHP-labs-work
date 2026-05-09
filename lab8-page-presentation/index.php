<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/controllers/MainController.php';

$routes = require __DIR__ . '/routes.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = rawurldecode($requestPath);

$content = '';
$title = null;

foreach ($routes as $pattern => $route) {
    if (preg_match($pattern, $requestPath, $matches)) {
        $controllerName = $route['controller'];
        $actionName = $route['action'];

        $controller = new $controllerName();

        array_shift($matches);

        $pageData = $controller->$actionName(...$matches);

        $content = $pageData['content'] ?? '';
        $title = $pageData['title'] ?? null;

        break;
    }
}

if ($content === '') {
    http_response_code(404);

    $content = '
        <h2>Ошибка 404</h2>
        <p>Страница не найдена.</p>
    ';
}

require __DIR__ . '/templates/main.php';