<?php
use App\Config\AppEnv;
use App\Routing\Router;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

AppEnv::load(APP_ROOT);

$container = require APP_ROOT . '/config/di.php';

// Initialize database
$dbConfig = APP_ROOT . '/config/database.php';
$dbConnection = DriverManager::getConnection($dbConfig);

// Register database in DI container
$container->set(Connection::class, fn() => $dbConnection);

// Initialize router
$router = new Router();

// Register routes with DI
require APP_ROOT . '/config/routes.php';
