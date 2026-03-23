<?php
use App\Config\AppEnv;
use App\Routing\Router;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;


// Load constants
require __DIR__ . '/config/constants.php';

// Load ENV
AppEnv::load(APP_ROOT);

// Load DI config
$container = require APP_ROOT . '/config/di.php';

// Load database config (returns array)
$connectionParams = require APP_ROOT . '/config/database.php';

// Initialize Doctrine DBAL connection
$dbConnection = DriverManager::getConnection($connectionParams);

// Register database in DI container
$container->set(Connection::class, fn() => $dbConnection);

// Initialize router
$router = new Router();
$container->set(Router::class, fn() => $router);

// Load routes
require APP_ROOT . '/config/routes.php';
