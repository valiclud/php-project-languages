<?php

function loadTemplate($templateFileName, $variables) {
extract($variables);

ob_start();
include __DIR__ . '/../templates/'.$templateFileName;

return ob_get_clean();
}

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/OriginalTextController.php';

    $originalTextTable = new DatabaseTable($pdo, 'original_text', 'id');
    $placesTable = new DatabaseTable($pdo, 'place', 'id');
    $languageTable = new DatabaseTable($pdo, 'old_language', 'id');
    $translatedTextTable = new DatabaseTable($pdo, 'translated_text', 'id');

    $originalTextController = new OriginalTextController($originalTextTable, $translatedTextTable, $placesTable, $languageTable);

    $action = $_GET['action'] ?? 'home';

    if ($action == strtolower($action)) {
        $page = $originalTextController->$action();
    } else {
        http_response_code(301);
        header('location: index.php?action=' . strtolower($action));
        exit;
    }

    $title = $page['title'];
    $output = $page['output'];
    $variables = $page['variables'] ?? [];
    $output = loadTemplate($page['template'], $variables);

} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';