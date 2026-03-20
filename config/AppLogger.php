<?php
namespace App\Config;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger {
    public static function getLogger(string $channel = 'app'): Logger {
        $logger = new Logger($channel);

        // Log to storage/logs/app.log
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::DEBUG));

        return $logger;
    }
}
