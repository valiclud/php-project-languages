<?php
// public/api.php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../vendor/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$oldTextWebsite = new \classes\api\OldTextWebsiteApi();
$entryPoint = new \classes\api\EntryPointApi($oldTextWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
