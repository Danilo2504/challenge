<?php
require 'config.php';
require 'app/core/router.php';

$router = new Router();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header('Content-Type: application/json; charset=UTF-8');

require 'router/router.php';

$router->run();
