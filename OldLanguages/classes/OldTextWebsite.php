<?php

namespace classes;

class OldTextWebsite implements \classes\Website
{

    private ?\classes\DatabaseTable $originalTextTable;
    private ?\classes\DatabaseTable $placesTable;
    private ?\classes\DatabaseTable $languageTable;
    private ?\classes\DatabaseTable $translatedTextTable;
    private ?\classes\DatabaseTable $authorsTable;
    private ?\classes\DatabaseTable $paginationTable;
    private ?\classes\Authentication $authentication;

    public function __construct()
    {
        try {
            $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
            $this->placesTable = new \classes\DatabaseTable($pdo, 'place', 'id', '\entities\Place');
            $this->languageTable = new \classes\DatabaseTable($pdo, 'old_language', 'id', '\entities\OldLanguage');
            $this->originalTextTable = new \classes\DatabaseTable($pdo, 'original_text', 'id', '\entities\OriginalText', [&$this->placesTable, &$this->languageTable]);
            $this->translatedTextTable = new \classes\DatabaseTable($pdo, 'translated_text', 'id', '\entities\TranslatedText', [&$this->originalTextTable]);
            $this->authorsTable = new \classes\DatabaseTable($pdo, 'author', 'id', '\entities\Author');
            $this->paginationTable = new \classes\DatabaseTable($pdo, 'pagination', 'id', '\entities\Pagination');
            $this->authentication = new \classes\Authentication($this->authorsTable, 'email', 'password');
        } catch (\PDOException $e) {
            echo "<script>console.log('$e');</script>";
            echo "$e";
            //throw new \PDOException($e);
        }
    }

    public function getLayoutVariables(): array
    {
        return [
            'loggedIn' => $this->authentication->isLoggedIn()
        ];
    }

    public function getDefaultRoute() : string
    {
        return 'originaltext/home';
    }

    public function getController(string $controllerName): ?object
    {
        $controllers = [
            'originaltext' => new \controllers\OriginalTextController($this->placesTable, $this->languageTable, $this->originalTextTable, $this->translatedTextTable,
            $this->paginationTable, $this->authentication),
            'translatedtext' => new \controllers\TranslatedTextController($this->translatedTextTable, $this->originalTextTable,$this->paginationTable, 
            $this->authentication),
            'author' => new \controllers\AuthorController($this->authorsTable),
            'login' => new \controllers\LoginController($this->authentication),
            'pagination' => new \controllers\PaginationController($this->paginationTable),
            'api' => new \controllers\api\TranslatedTextApiController($this->translatedTextTable, $this->originalTextTable,$this->paginationTable, 
            $this->authentication)
          ];

          return $controllers[$controllerName] ?? null;
/*
        if ($controllerName === 'originaltext') {
            $controller =  new \controllers\OriginalTextController($this->placesTable, $this->languageTable, $this->originalTextTable, $this->translatedTextTable,
             $this->paginationTable, $this->authentication);
        } else if ($controllerName === 'translatedtext') {
            $controller = new \controllers\TranslatedTextController($this->translatedTextTable, $this->originalTextTable,$this->paginationTable, 
             $this->authentication);
        } else if ($controllerName === 'author') {
            $controller = new \controllers\AuthorController($this->authorsTable);
        } else if ($controllerName == 'login') {
            $controller = new \controllers\LoginController($this->authentication);
        } else if ($controllerName == 'pagination') {
            $controller = new \controllers\PaginationController($this->paginationTable);
        } else if ($controllerName == 'api') {
            $controller = new \controllers\api\TranslatedTextApiController($this->translatedTextTable, $this->originalTextTable,$this->paginationTable, 
            $this->authentication);
        } else {
            $controller = null;
        }

        return $controller;
        */
    }

    public function checkLogin(string $uri): ?string
    {
        $restrictedPages = ['originaltext/edit', 'originaltext/delete', 'originaltext/save'];

        if (in_array($uri, $restrictedPages) && !$this->authentication->isLoggedIn()) {
            header('location: /login/login');
            exit();
        }

        return $uri;
    }
}
