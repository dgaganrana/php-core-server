<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Http\Response;

class HealthController extends BaseController
{
    public function checkWeb(): Response
    {
        $this->logger->info('Web health check accessed');

        $html = file_get_contents(APP_ROOT . '/public/healthPage.php');
        return Response::html($html);
    }

    public function checkApi(): Response
    {
        $this->logger->info('API health check accessed');

        return Response::json(['status' => 'ok']);
    }
}
