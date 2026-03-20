<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

final class HealthApiTest extends TestCase
{
    private string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        // Use env var or fallback to common local dev server
        $this->baseUrl = rtrim(getenv('APP_URL') ?: 'http://127.0.0.1:8000', '/');
    }

    public function testHealthEndpointFailsOnWrongUrl(): void
    {
        $url = $this->baseUrl . '/api/invalid';

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'timeout'       => 5,
                'header'        => "Accept: application/json\r\n",
            ]
        ]);

        $json = file_get_contents($url, false, $context);

        if ($json === false) {
            $error = error_get_last();
            $this->fail("Failed to fetch $url: " . ($error['message'] ?? 'Unknown error'));
        }

        $data = json_decode($json, true);
        $this->assertIsArray($data, "Response was not valid JSON. Raw: " . substr($json, 0, 200));
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Not Found', $data['error']);
    }

    public function testHealthEndpointReturnsOk(): void
    {
        $url = $this->baseUrl . '/api/health';

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'timeout'       => 5,
                'header'        => "Accept: application/json\r\n",
            ]
        ]);

        $json = file_get_contents($url, false, $context);

        if ($json === false) {
            $error = error_get_last();
            $this->fail("Failed to fetch $url: " . ($error['message'] ?? 'Unknown error'));
        }

        $data = json_decode($json, true);
        $this->assertIsArray($data, "Response was not valid JSON. Raw: " . substr($json, 0, 200));
        $this->assertEquals('ok', $data['status'] ?? null);
    }
}