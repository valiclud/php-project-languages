<?php
include __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$oldTextWebsite = new \classes\OldTextWebsite();
$entryPoint = new \classes\EntryPoint($oldTextWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);