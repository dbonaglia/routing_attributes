<?php

namespace App\Attributes;

#[Attribute]
class Route {
    private array $routes = [];

    public function __construct(string $url, string $callback) {
        $this->routes[$url] = [
            'callback' => $callback
        ];
    }
}