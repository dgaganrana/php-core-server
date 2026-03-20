<?php
namespace App\Controllers;

use App\Http\Response;

class HealthController
{
    public function checkWeb(): Response
    {
        $html = file_get_contents(APP_ROOT . '/public/healthPage.php');
        return Response::html($html);
    }

    public function checkApi(): Response
    {
        return Response::json(['status' => 'ok']);
    }
}
