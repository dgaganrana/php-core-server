<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;
use App\Config\AppLogger;
use Psr\Http\Message\ResponseInterface;

final class HomePageLoggingTest extends TestCase
{
    public function test_home_page_access_should_be_logged(): void
    {
        $logFile = APP_ROOT . '/storage/logs/app.log';
        if (file_exists($logFile)) {
            unlink($logFile);
        }

        // Inject logger via BaseController DI
        $logger = AppLogger::getLogger();
        $controller = new HomeController($logger);

        /** @var ResponseInterface $response */
        $response = $controller->index();

        // Assert response content
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('text/html; charset=UTF-8', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString(
            '<title>My Test Home Page</title>',
            $response->getBody()->getContents()
        );

        // Assert log file created and contains entry
        $this->assertFileExists($logFile);
        $logContents = file_get_contents($logFile);
        $this->assertStringContainsString('Home page accessed', $logContents);
    }
}
