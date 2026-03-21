<?php
declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;

// Load constants
require __DIR__ . '/constants.php';

return new PhpFile(APP_ROOT . '/migrations-config.php');
