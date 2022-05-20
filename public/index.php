<?php

require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{\d+}');
$router->add('password/reset/{[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);

$router->dispatch($path);
