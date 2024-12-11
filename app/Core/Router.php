<?php

namespace App\Core;

class Router {
    private $routes = [];

    public function addRoute($method, $route, $action) {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'action' => $action
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($method == $route['method'] && preg_match("#^{$route['route']}$#", $uri)) {
                call_user_func($route['action']);
                return;
            }
        }

        echo "Página no encontrada";
    }
}
