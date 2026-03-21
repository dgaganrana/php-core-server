<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Utils;

class HomeController extends BaseController
{
    public function index(): ResponseInterface
    {
        $this->logger->info(__CLASS__ . '::' . __METHOD__ . ' - Home page accessed');

        // Render view into buffer
        ob_start();
        require APP_ROOT . '/public/homePage.php';
        $content = ob_get_clean();

        // Build PSR-7 response
        $response = new \App\Http\Response(200);
        $response = $response
            ->withHeader('Content-Type', 'text/html; charset=UTF-8')
            ->withBody(Utils::streamFor($content));

        return $response;
    }
}
