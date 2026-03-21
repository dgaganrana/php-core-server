<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;
use App\Config\AppLogger;
use Psr\Http\Message\ResponseInterface;

final class HomePageTest extends TestCase
{
    public function testHomePageLoadsSuccessfully(): void
    {
        // Arrange: inject logger via BaseController
        $logger = AppLogger::getLogger();
        $controller = new HomeController($logger);

        // Act: call controller action
        /** @var ResponseInterface $response */
        $response = $controller->index();

        // Assert: response is valid PSR-7 object
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('text/html; charset=UTF-8', $response->getHeaderLine('Content-Type'));

        $body = $response->getBody()->getContents();
        $this->assertNotEmpty($body, "Home page body should not be empty");
        $this->assertStringContainsString('<title>', $body);
    }
}
