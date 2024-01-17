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

    $route = $_GET['route'] ?? 'originaltext/home'; //if no route variable is set, use 'joke/home'

	if ($route == strtolower($route)) {

			if ($route === 'originaltext/list') {
				include __DIR__ . '/../classes/controllers/OriginalTextController.php';
				$controller =  new OriginalTextController($originalTextTable, $translatedTextTable, $placesTable, $languageTable);
				$page = $controller->list();
			}
			else if ($route === 'originaltext/home') {
				include __DIR__ . '/../classes/controllers/OriginalTextController.php';
				$controller =  new OriginalTextController($originalTextTable, $translatedTextTable, $placesTable, $languageTable);
				$page = $controller->home();
			}else {
        http_response_code(301);
        header('location: index.php?action=' . strtolower($action));
        exit;
    }
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