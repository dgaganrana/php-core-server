<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Config\AppEnv;
use App\Routing\Router;
use App\Http\Response;

AppEnv::load(APP_ROOT);

$router = new Router();

// Load route definitions
require APP_ROOT . '/config/routes.php';

try {
    $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = strtoupper($_SERVER['REQUEST_METHOD']);

    // Dispatch always returns a Response
    $response = $router->dispatch($uri, $method);
    $response->send();

} catch (\Throwable $e) {
    Response::json([
        'error'   => 'Internal Server Error',
        'message' => $e->getMessage()
    ], 500)->send();
}
