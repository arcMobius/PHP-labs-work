<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
});

$routes = require __DIR__ . '/src/routes.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = rawurldecode($requestPath);

foreach ($routes as $pattern => $route) {
    if (preg_match($pattern, $requestPath, $matches)) {
        $controllerName = $route[0];
        $actionName = $route[1];

        $controller = new $controllerName();

        array_shift($matches);

        $controller->$actionName(...$matches);
        return;
    }
}

http_response_code(404);

$view = new \MyProject\View\View(__DIR__ . '/templates');
$view->renderHtml('errors/404.php', [], 404);