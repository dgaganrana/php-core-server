<?php
declare(strict_types=1);

namespace App\Config;

use App\Config\AppEnv;
use Doctrine\DBAL\Tools\DsnParser;

$dsn = sprintf(
    'pgsql://%s:%s@%s:%d/%s',
    AppEnv::get('DB_USER'),
    AppEnv::get('DB_PASS'),
    AppEnv::get('DB_HOST'),
    (int) (AppEnv::get('DB_PORT') ?? 5432),
    AppEnv::get('DB_NAME')
);

$dsnParser = new DsnParser();
return $dsnParser->parse($dsn);