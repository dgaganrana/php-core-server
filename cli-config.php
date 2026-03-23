<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Config\AppEnv;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\DBAL\DriverManager;

// Load the correct .env file based on APP_ENV
AppEnv::load(__DIR__);  // points to project root (where .env / .env.dev / .env.testing live)

// Now environment variables are available
$connectionParams = [
    'host'     => $_ENV['DB_HOST']     ?? 'localhost',
    'port'     => (int) ($_ENV['DB_PORT'] ?? 5432),
    'dbname'   => $_ENV['DB_NAME']     ?? 'php-core-server_db',
    'user'     => $_ENV['DB_USER']     ?? 'php-core-server_user',
    'password' => $_ENV['DB_PASS']     ?? 'php-core-server_password',
    'driver'   => 'pdo_pgsql',          // Postgres via PgBouncer
];

// Optional: more robust fallback or validation
if (empty($connectionParams['host']) || empty($connectionParams['dbname'])) {
    throw new RuntimeException('Missing required DB environment variables');
}

// PgBouncer note: use 'pdo_pgsql' driver; it works transparently with session/transaction pooling

$connection = DriverManager::getConnection($connectionParams);

// Your migrations config (the array-returning file)
$config = new PhpFile(__DIR__ . '/config/migrations.php');  // or migrations-config.php if you kept that name

return DependencyFactory::fromConnection(
    $config,
    new ExistingConnection($connection)
);
