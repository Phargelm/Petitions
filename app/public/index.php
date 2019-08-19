<?php

use App\Core\Router;

$container = require_once __DIR__ . '/../config/bootstrap.php';

/**
 * @var Router $router
 */
$router = $container->make(Router::class);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$actionParams = $router->getAction($path, $_SERVER['REQUEST_METHOD']);

if (!$actionParams) {
    http_response_code(404);
    die('404. Not found');
}

$controller = $container->make($actionParams['controller']);

call_user_func([$controller, $actionParams['action']], $_REQUEST);