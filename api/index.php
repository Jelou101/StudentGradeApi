<?php
require_once __DIR__ . '/config/Database.php';  //
require_once __DIR__ . '/core/router.php';     //

$router = new Router();
$router->handleRequest();
