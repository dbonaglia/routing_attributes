<?php

require '../vendor/autoload.php';

function getClassesFromDirectory() {
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

$classes = getClassesFromDirectory();

foreach ($classes as $class) {
    $reflection = new ReflectionClass($class); // It's works, but have to find an other way to do it without make an instance for each controller...
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
