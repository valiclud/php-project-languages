<?php

namespace classes\api;

class EntryPointApi
{
    public function __construct(private \classes\Website $website) {}

    public function run(string $uri, string $method): void
    {
        try {
            $this->checkUri($uri);
            if ($uri == 'api') {
                $uri = $this->website->getDefaultRoute();
            }

            $route = explode('/', $uri);
            array_shift($route);
            $controllerName = array_shift($route);
            $action = array_shift($route);

            if ($method === 'POST') {
                $action .= 'Submit';
            }

            $controller = $this->website->getController($controllerName);
            if (is_callable([$controller, $action])) {
                $page = $controller->$action(...$route);
            } else {
                http_response_code(404);
                $title = 'Not found';
                $output = 'Sorry, the page you are looking for could not be found.';
            }
        } catch (\PDOException $e) {
            $title = 'An error has occurred';

            $output = 'Database error: ' . $e->getMessage() . ' in ' .
                $e->getFile() . ':' . $e->getLine();
        }
    }

    private function checkUri(string $uri): void
    {
        if ($uri != strtolower($uri)) {
            http_response_code(301);
            header('location: ' . strtolower($uri));
        }
    }
}
