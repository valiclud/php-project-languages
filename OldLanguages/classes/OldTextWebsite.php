<?php

namespace classes;

class OldTextWebsite {

private ?\classes\DatabaseTable $originalTextTable;
private ?\classes\DatabaseTable $placesTable;
private ?\classes\DatabaseTable $languageTable;
private ?\classes\DatabaseTable $translatedTextTable;
private ?\classes\DatabaseTable $authorsTable;
private ?\classes\Authentication $authentication;

public function __construct() {
    $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
    $this->placesTable = new \classes\DatabaseTable($pdo, 'place', 'id', '\entities\Place');
    $this->languageTable = new \classes\DatabaseTable($pdo, 'old_language', 'id', '\entities\OldLanguage');
    $this->originalTextTable = new \classes\DatabaseTable($pdo, 'original_text', 'id', '\entities\OriginalText', [&$this->placesTable, &$this->languageTable]);
    $this->translatedTextTable = new \classes\DatabaseTable($pdo, 'translated_text', 'id', '\entities\TranslatedText', [&$this->originalTextTable]);
    $this->authorsTable = new \classes\DatabaseTable($pdo, 'author', 'id', '\entities\Author');
    $this->authentication = new \classes\Authentication($this->authorsTable, 'email', 'password');
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
        $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');

        if ($controllerName === 'originaltext') {
            $controller =  new \controllers\OriginalTextController($this->originalTextTable, $this->translatedTextTable, $this->placesTable, $this->languageTable, $this->authentication);
        }
        else if ($controllerName === 'translatedtext') {
            $controller = new \controllers\TranslatedTextController($this->translatedTextTable, $this->originalTextTable, $this->authentication);
        }
       else if ($controllerName === 'author') {
            $controller = new \controllers\AuthorController($this->authorsTable);
        }
        else if ($controllerName == 'login') {
            $controller = new \controllers\LoginController($this->authentication);
        }
        else {
            $controller = null;
        }

        return $controller;
    }

    public function checkLogin(string $uri): ?string {
       $restrictedPages = ['originaltext/edit', 'originaltext/delete', 'originaltext/save'];

        if (in_array($uri, $restrictedPages) && !$this->authentication->isLoggedIn()) {
            header('location: /login/login');
            exit();
        }

        return $uri;
        
    }
}