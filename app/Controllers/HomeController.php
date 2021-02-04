<?php

namespace App\Controllers;

class HomeController {

    #[Route('/')]
    public function home() {
        dump('Hello there, homepage');
    }
}