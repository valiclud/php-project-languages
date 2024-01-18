<?php
class OldTextWebsite {
    public function getDefaultRoute() {
        return 'originaltext/home';
    }

    public function getController(string $controllerName):? object {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../classes/DatabaseTable.php';
        include __DIR__ . '/../controllers/OriginalTextController.php';
        include __DIR__ . '/../controllers/AuthorController.php';

        $originalTextTable = new DatabaseTable($pdo, 'original_text', 'id');
        $placesTable = new DatabaseTable($pdo, 'place', 'id');
        $languageTable = new DatabaseTable($pdo, 'old_language', 'id');
        $translatedTextTable = new DatabaseTable($pdo, 'translated_text', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        if ($controllerName === 'originaltext') {
            $controller =  new OriginalTextController($originalTextTable, $translatedTextTable, $placesTable, $languageTable);
        }
       else if ($controllerName === 'author') {
            $controller = new AuthorController($authorsTable);
        }
        else {
            $controller = null;
        }

        return $controller;
    }
}