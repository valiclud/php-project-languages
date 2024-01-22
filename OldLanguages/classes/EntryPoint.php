<?php

namespace classes;
class EntryPoint {
    public function __construct(private $website) {
    }

    public function run($uri, $method) {
        try {
            $this->checkUri($uri);
            if ($uri == '' || $uri == 'originaltext') {
                $uri = $this->website->getDefaultRoute();
            }

            $route = explode('/', $uri);

            $controllerName = array_shift($route);
            $action = array_shift($route);

            if ($method === 'POST') {
                $action .= 'Submit';
            }

            $controller = $this->website->getController($controllerName);

            if (is_callable([$controller, $action])) {
                $page = $controller->$action(...$route);
                $title = $page['title'];
                $variables = $page['variables'] ?? [];
                
                $output = $this->loadTemplate($page['template'], $variables);
            }
            else {
                http_response_code(404);
                $title = 'Not found';
                $output = 'Sorry, the page you are looking for could not be found.';
            }
            
        } catch (\PDOException $e) {
            $title = 'An error has occurred';

            $output = 'Database error: ' . $e->getMessage() . ' in ' .
            $e->getFile() . ':' . $e->getLine();
        }

        $layoutVariables = $this->website->getLayoutVariables();
        $layoutVariables['title'] = $title;
        $layoutVariables['output'] = $output;

        echo $this->loadTemplate('layout.html.php', $layoutVariables);
    }

    private function loadTemplate($templateFileName, $variables) {
        extract($variables);

        ob_start();
        include  __DIR__ . '/../templates/' . $templateFileName;

        return ob_get_clean();
    }

    private function checkUri($uri) {
        if ($uri != strtolower($uri)) {
            http_response_code(301);
            header('location: ' . strtolower($uri));
        }
    }
}