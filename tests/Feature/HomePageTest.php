<?php
declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

final class HomePageTest extends TestCase
{
    public function testHomePageLoadsSuccessfully(): void
    {
        $url = getenv('APP_URL') ?: 'http://127.0.0.1:8000';

        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $html = @file_get_contents($url, false, $context);

        // Expect non-empty HTML and a <title> tag
        $this->assertNotFalse($html, "Home page did not load");
        $this->assertStringContainsString('<title>', $html);
    }
}
