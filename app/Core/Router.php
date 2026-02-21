<?php

namespace App\Core;

class Router
{
    public function dispatch(string $uri): void
    {
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);

        $controllerName = !empty($segments[0])
            ? ucfirst($segments[0]) . 'Controller'
            : 'HomeController';

        $method = $segments[1] ?? 'index';

        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo "Controller not found.";
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            http_response_code(404);
            echo "Method not found.";
            return;
        }

        $controller->$method();
    }
}
