<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Utils;
use App\Http\Response;

class HealthController extends BaseController
{
    public function checkWeb(): ResponseInterface
    {
        $this->logger->info(__CLASS__ . '::' . __METHOD__ . ' - Web health check accessed');

        $html = file_get_contents(APP_ROOT . '/public/homePage.php');

        $response = new Response(200);
        $response = $response
            ->withHeader('Content-Type', 'text/html; charset=UTF-8')
            ->withBody(Utils::streamFor($html));

        return $response;
    }

    public function checkApi(): ResponseInterface
    {
        $this->logger->info(__CLASS__ . '::' . __METHOD__ . ' - API health check accessed');

        $response = new Response(200);
        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Utils::streamFor(json_encode(['status' => 'ok'], JSON_THROW_ON_ERROR)));

        return $response;
    }
}
