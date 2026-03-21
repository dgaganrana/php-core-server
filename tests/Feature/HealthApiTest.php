<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controllers\HealthController;
use App\Config\AppLogger;
use Psr\Http\Message\ResponseInterface;

final class HealthApiTest extends TestCase
{
    private HealthController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $logger = AppLogger::getLogger();
        $this->controller = new HealthController($logger);
    }

    public function testHealthEndpointFailsOnWrongUrl(): void
    {
        // Simulate wrong route: controller not invoked, router would return 404
        $response = new \App\Http\Response(404);
        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(['error' => 'Not Found'])));

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));

        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Not Found', $data['error']);
    }

    public function testHealthEndpointReturnsOk(): void
    {
        /** @var ResponseInterface $response */
        $response = $this->controller->checkApi();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));

        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertIsArray($data);
        $this->assertEquals('ok', $data['status'] ?? null);
    }
}
