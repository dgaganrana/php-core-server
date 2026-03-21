<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Http\Response;

try {
    $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = strtoupper($_SERVER['REQUEST_METHOD']);

    // Ask container to resolve controller dependencies
    $response = $router->dispatch($uri, $method, $container);
    $response->send();

} catch (\Throwable $e) {
    $logger = App\Config\AppLogger::getLogger();
    $logger = $container->get(Monolog\Logger::class);
    $logger->error("Unhandled exception", ['exception' => $e]);

    Response::json([
        'error'   => 'Internal Server Error',
        'message' => 'Something went wrong'
    ], 500)->send();
}
