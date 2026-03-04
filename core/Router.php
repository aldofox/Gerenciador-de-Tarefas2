<?php

class Router{
    private $routes = [];

    public function get($uri, $action, $middleware = null){

    if ($middleware === null) {
        $this->routes['GET'][$uri] = $action;
        return;
    }

    $this->routes['GET'][$uri] = [
        'action' => $action,
        'middleware' => $middleware
    ];
}


    public function post($uri, $action){
        $this->routes['POST'][$uri] = $action;
    }

    public function run() {

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($uri === '') {
        $uri = '/';
    }

    if (isset($this->routes[$httpMethod][$uri])) {

        $route = $this->routes[$httpMethod][$uri];

        // 🔥 Se for rota antiga (sem middleware)
        if (isset($route[0])) {
            $controller = new $route[0];
            $controllerMethod = $route[1];
            $controller->$controllerMethod();
            return;
        }

        // 🔐 Se for rota nova com middleware
        if (isset($route['middleware']) && $route['middleware']) {

            require_once __DIR__ . '/../Middleware/' . $route['middleware'] . '.php';
            $middleware = new $route['middleware'];
            $middleware->handle();
        }

        $controller = new $route['action'][0];
        $controllerMethod = $route['action'][1];
        $controller->$controllerMethod();

    } else {
        http_response_code(404);
        echo "404 - Página não encontrada";
    }
}


}