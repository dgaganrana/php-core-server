<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;
use App\Config\AppLogger;

final class HomePageLoggingTest extends TestCase
{
    public function test_home_page_access_should_be_logged(): void
    {
        $logFile = APP_ROOT . '/storage/logs/app.log';
        if (file_exists($logFile)) {
            unlink($logFile);
        }

        // Manually inject the logger
        $logger = AppLogger::getLogger();
        $controller = new HomeController($logger);

        $response = $controller->index();

        $this->assertStringContainsString('<title>My Test Home Page</title>', $response->getBody());

        $this->assertFileExists($logFile);
        $logContents = file_get_contents($logFile);
        $this->assertStringContainsString('Home page accessed', $logContents);
    }
}
