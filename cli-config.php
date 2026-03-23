<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/constants.php';

use App\Config\AppEnv;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\DBAL\DriverManager;

// Load the correct .env file based on APP_ENV
AppEnv::load(APP_ROOT);

// Load database config
$connectionParams = require APP_ROOT . '/config/database.php';

// Optional: more robust fallback or validation
if (empty($connectionParams['host']) || empty($connectionParams['dbname'])) {
    throw new RuntimeException('Missing required DB environment variables');
}

// PgBouncer note: use 'pdo_pgsql' driver; it works transparently with session/transaction pooling

$connection = DriverManager::getConnection($connectionParams);

// Your migrations config (the array-returning file)
$config = new PhpFile(APP_ROOT . '/config/migrations.php');

return DependencyFactory::fromConnection(
    $config,
    new ExistingConnection($connection)
);
