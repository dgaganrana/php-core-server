<?php
use App\Controllers\HomeController;
use App\Controllers\HealthController;

// Web routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'checkWeb']);

// API routes
$router->get('/api/health', [HealthController::class, 'checkApi']);
