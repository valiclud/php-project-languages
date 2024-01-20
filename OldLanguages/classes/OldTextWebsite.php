<?php

class OldTextWebsite {

private DatabaseTable $originalTextTable;
private DatabaseTable $placesTable;
private DatabaseTable $languageTable;
private DatabaseTable $translatedTextTable;
private DatabaseTable $authorsTable;
private Authentication $authentication;

public function __construct() {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
    $this->originalTextTable = new DatabaseTable($pdo, 'original_text', 'id');
    $this->placesTable = new DatabaseTable($pdo, 'place', 'id');
    $this->languageTable = new DatabaseTable($pdo, 'old_language', 'id');
    $this->translatedTextTable = new DatabaseTable($pdo, 'translated_text', 'id');
    $this->authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
}

    public function getLayoutVariables(): array {
        return [
            'loggedIn' => $this->authentication->isLoggedIn()
        ];
    }

    public function getDefaultRoute() {
        return 'originaltext/home';
    }

    public function getController(string $controllerName):? object {
        $pdo = new PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
        include __DIR__ . '/../controllers/OriginalTextController.php';
        include __DIR__ . '/../controllers/AuthorController.php';
        include __DIR__ . '/../controllers/LoginController.php';

        if ($controllerName === 'originaltext') {
            $controller =  new OriginalTextController($this->originalTextTable, $this->translatedTextTable, $this->placesTable, $this->languageTable);
        }
       else if ($controllerName === 'author') {
            $controller = new AuthorController($this->authorsTable);
        }
        else if ($controllerName == 'login') {
            $controller = new LoginController($this->authentication);
        }
        else {
            $controller = null;
        }

        return $controller;
    }

    public function checkLogin(string $uri): ?string {
        $restrictedPages = ['originaltext/edit', 'originaltext/delete'];

        if (in_array($uri, $restrictedPages) && !$this->authentication->isLoggedIn()) {
            header('location: /login/login');
            exit();
        }

        return $uri;
    }
}