<?php
declare(strict_types=1);

namespace App\Config;

use Dotenv\Dotenv;

final class AppEnv
{
    public static function load(string $baseDir): void
    {
        $env = getenv('APP_ENV') ?: 'development';

        switch ($env) {
            case 'testing':
                $file = '.env.testing';
                break;
            case 'development':
                $file = '.env.dev';
                break;
            default:
                $file = '.env';
        }

        $dotenv = Dotenv::createImmutable($baseDir, $file);
        $dotenv->safeLoad();
    }
}

// use Dotenv\Dotenv;

// function loadEnv(): void {
//     // Decide which env file to load based on APP_ENV
//     $env = getenv('APP_ENV') ?: 'development';

//     switch ($env) {
//         case 'testing':
//             $file = '.env.testing';
//             break;
//         case 'development':
//             $file = '.env.dev';
//             break;
//         default:
//             $file = '.env';
//     }

//     $dotenv = Dotenv::createImmutable(dirname(__DIR__), $file);
//     $dotenv->safeLoad();
// }

