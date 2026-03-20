<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Config\AppLogger;
use Monolog\Logger;

class AppLoggerTest extends TestCase
{
    public function test_logger_instance_is_created()
    {
        $logger = AppLogger::getLogger();
        $this->assertInstanceOf(Logger::class, $logger);
    }
}