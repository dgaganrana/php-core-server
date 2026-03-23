<?php
declare(strict_types=1);

namespace App\Config;

use Dotenv\Dotenv;
use RuntimeException;

final class AppEnv
{
    public static function load(string $baseDir): void
    {
        $env = getenv('APP_ENV') ?: 'development';

        $file = match ($env) {
            'testing'     => '.env.testing',
            'development' => '.env.dev',
            default       => '.env',
        };

        $dotenv = Dotenv::createImmutable($baseDir, $file);
        $dotenv->safeLoad();

        // Optional: fail early if critical vars are missing
        $required = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'];
        foreach ($required as $key) {
            if (!isset($_ENV[$key]) || $_ENV[$key] === '') {
                throw new RuntimeException("Missing required env var: $key");
            }
        }
    }
}