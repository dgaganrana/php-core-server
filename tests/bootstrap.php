<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Config\AppEnv;
// Load ENV
AppEnv::load(APP_ROOT);
