<?php
use App\Config\AppEnv;
use App\Routing\Router;

AppEnv::load(APP_ROOT);

$container = require APP_ROOT . '/config/di.php';

// Initialize router
$router = new Router();

// Register routes with DI
require APP_ROOT . '/config/routes.php';
