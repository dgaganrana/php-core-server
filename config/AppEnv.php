<?php
declare(strict_types=1);

namespace App\Config;

use Dotenv\Dotenv;
use RuntimeException;

final class AppEnv
{
    public static function load(string $baseDir): void
    {
        // Load environment variables from .env into $_ENV
        $dotenv = Dotenv::createImmutable($baseDir, '.env');
        $dotenv->safeLoad();

        // Fail early if critical vars are missing
        $required = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'];
        foreach ($required as $key) {
            if (!isset($_ENV[$key]) || $_ENV[$key] === '') {
                throw new RuntimeException("Missing required env var: $key");
            }
        }
    }

    public static function get(string $key, ?string $default = null): string
    {
        return $_ENV[$key] ?? $default ?? throw new RuntimeException("Missing env var: $key");
    }
}
