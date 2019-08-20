<?php declare(strict_types=1);

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

try {
    call_user_func([$controller, $actionParams['action']], $_REQUEST);
} catch (\Throwable $exception) {
    http_response_code(500);
    // In production mode we can provide only common message.
    echo 'Unexpected error is occurred. Please, contact us: foo@bar.baz<br>';
    // In debug mode exception message can be displayed.
    echo $exception; // will be converted to string via $exception->__toString()
}