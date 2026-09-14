<?php
// --- GLOBÁLNÍ CORS OŠETŘENÍ ---
// 1. Povolíme React aplikaci
header("Access-Control-Allow-Origin: http://localhost:5173");
// 2. Povolíme všechny potřebné metody včetně DELETE a OPTIONS
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// 3. Povolíme hlavičky, které React (Axios/Fetch) posílá
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// 4. Povolíme přenos cookies/přihlášení, pokud je vyžadováno
header("Access-Control-Allow-Credentials: true");

// 5. KLÍČOVÝ KROK: Pokud prohlížeč posílá preflight (OPTIONS), PHP ho ihned schválí a ukončí se
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// --- KONEC CORS OŠETŘENÍ ---
// public/api.php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../vendor/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$oldTextWebsite = new \classes\api\OldTextWebsiteApi();
$entryPoint = new \classes\api\EntryPointApi($oldTextWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
