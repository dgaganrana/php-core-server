<?php
namespace App\Controllers;

use App\Http\Response;
use Monolog\Logger;

class HomeController {
    private Logger $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function index(): Response {
        $this->logger->info("Home page accessed");

        ob_start();
        require APP_ROOT . '/public/homePage.php';
        $content = ob_get_clean();

        return new Response(200, [], $content);
    }
}
