<?php

require '../Core/Router.php';

require '../App/Controllers/Home.php';
require '../App/Controllers/Posts.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{\d+}');

$router->dispatch($path);
