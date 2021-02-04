<?php

namespace App\Controllers;

class AboutController {
    
    #[Route('/about')]
    public function about() {
        dump('Hello there, about page');
    }
}