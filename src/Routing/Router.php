<?php
namespace App\Routing;

use App\Http\Response;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable|array $handler): void
    {
        $method = strtoupper($method);
        $this->routes[$method][$path] = $handler;
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function put(string $path, callable|array $handler): void
    {
        $this->add('PUT', $path, $handler);
    }

    public function delete(string $path, callable|array $handler): void
    {
        $this->add('DELETE', $path, $handler);
    }

    /**
     * Dispatch the request to the correct handler
     * Assumes $path and $method are already normalized by index.php
     */
    public function dispatch(string $path, string $method): Response
    {
        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            return Response::json(['error' => 'Not Found'], 404);
        }

        if (is_array($handler)) {
            [$class, $action] = $handler;
            $controller = new $class();
            return $this->normalizeResponse($controller->$action());
        }

        if (is_callable($handler)) {
            return $this->normalizeResponse($handler());
        }

        throw new \RuntimeException("Invalid route handler for $path");
    }

    private function normalizeResponse(mixed $result): Response
    {
        if ($result instanceof Response) {
            return $result;
        }
        return Response::html((string)$result);
    }
}
