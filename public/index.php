<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Http\Response;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Utils;

try {
    $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = strtoupper($_SERVER['REQUEST_METHOD']);

    /** @var ResponseInterface $response */
    $response = $router->dispatch($uri, $method, $container);

    // Emit response (PSR-7 style)
    http_response_code($response->getStatusCode());
    foreach ($response->getHeaders() as $name => $values) {
        foreach ((array)$values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    echo $response->getBody()->getContents();

} catch (\Throwable $e) {
    $logger = $container->get(\Psr\Log\LoggerInterface::class);
    $logger->error("Unhandled exception", ['exception' => $e]);

    $errorResponse = new Response(500);
    $errorResponse = $errorResponse
        ->withHeader('Content-Type', 'application/json')
        ->withBody(Utils::streamFor(json_encode([
            'error'   => 'Internal Server Error',
            'message' => 'Something went wrong'
        ], JSON_THROW_ON_ERROR)));

    http_response_code($errorResponse->getStatusCode());
    foreach ($errorResponse->getHeaders() as $name => $values) {
        foreach ((array)$values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    echo $errorResponse->getBody()->getContents();
}

