<?php
namespace App\Controllers;

class HomeController {
    public function index(): void {
        require APP_ROOT . '/public/homePage.php';
    }
}
