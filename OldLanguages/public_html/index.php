<?php
include_once '../classes/EntryPoint.php';
include_once '../classes/OldTextWebsite.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$oldTextWebsite = new OldTextWebsite();
$entryPoint = new EntryPoint($oldTextWebsite);
$entryPoint->run($uri);