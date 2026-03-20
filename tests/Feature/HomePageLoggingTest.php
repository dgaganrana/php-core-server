<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;

class HomePageLoggingTest extends TestCase
{
    public function test_home_page_access_should_be_logged()
    {
        $logFile = APP_ROOT . '/storage/logs/app.log';
        if (file_exists($logFile)) {
            unlink($logFile);
        }

        $response = (new HomeController())->index();
        $this->assertStringContainsString('<title>My Test Home Page</title>', $response->getBody());

        $this->assertFileExists($logFile);
        $logContents = file_get_contents($logFile);
        $this->assertStringContainsString('Home page accessed', $logContents);
    }
}
