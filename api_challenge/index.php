<?php
require 'config.php';
require 'app/core/router.php';

$router = new Router();

require 'router/router.php';

$router->run();
