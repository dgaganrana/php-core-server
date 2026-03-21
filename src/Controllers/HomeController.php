<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Http\Response;

class HomeController extends BaseController
{
    public function index(): Response
    {
        $this->logger->info("Home page accessed");

        ob_start();
        require APP_ROOT . '/public/homePage.php';
        $content = ob_get_clean();

        return new Response(200, [], $content);
    }
}
