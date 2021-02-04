<?php

require '../vendor/autoload.php';

function getClassFromDirectory(string $directory) {
    $controllers = [];
    if ($dir = opendir("../app/Controllers/")) {
        while($file = readdir($dir)) {
            if(strlen(pathinfo($file)['filename']) > 3) {
                $controllers[] = 'App\Controllers\\' . pathinfo($file)['filename'];
            }
        }
        closedir($dir);
    }
    return $controllers;
}

$classes = getClassFromDirectory('../app/Controllers/');

foreach ($classes as $class) {     
    $reflection = new ReflectionClass($class);
    foreach ($reflection->getMethods() as $method) {
        foreach ($method->getAttributes(App\Controllers\Route::class) as $attribute) {
            foreach ($attribute->getArguments() as $argument) {
                if ($_SERVER['REQUEST_URI'] === $argument) {
                    call_user_func([$reflection->newInstance(), $method->name]);
                }
            }
        }
    }
}
