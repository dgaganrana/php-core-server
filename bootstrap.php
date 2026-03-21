<?php
use App\Config\AppEnv;
use App\Config\AppLogger;
use App\Routing\Router;
use DI\ContainerBuilder;
use Monolog\Logger;

AppEnv::load(APP_ROOT);

// Build DI container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Logger::class => function () {
        // One shared logger instance
        return AppLogger::getLogger();
    }
]);

$container = $containerBuilder->build();

// Initialize router
$router = new Router();

// Register routes with DI
require APP_ROOT . '/config/routes.php';
