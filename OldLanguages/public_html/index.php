<?php
include __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$oldTextWebsite = new OldTextWebsite();
$entryPoint = new EntryPoint($oldTextWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);